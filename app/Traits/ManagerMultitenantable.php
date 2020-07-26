<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait ManagerMultitenantable
{
    public static function bootManagerMultitenantable()
    {
        if (Auth::guard()->check()) {
            static::creating(function($model)
            {
                if (Auth::guard()->user()->role == 'manager') {
                    $model->created_by_manager_id = Auth::guard()->user()->id;
                }
            });

            static::addGlobalScope('created_by_manager_id', function (Builder $builder)
            {
                if (Auth::guard()->check() && Auth::guard()->user()->role == 'manager') {
                    return $builder->where('created_by_manager_id', Auth::guard()->user()->id);
                }
            });
        }
    }
}
