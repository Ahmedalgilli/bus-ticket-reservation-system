<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait AdminMultitenantable
{
    public static function bootAdminMultitenantable()
    {
        // dd(Auth::guard()->user());
        if (Auth::guard()->check()) {
            static::creating(function($model)
            {
                if (Auth::guard()->user()->role == 'admin') {
                    $model->created_by_admin_id = Auth::guard()->user()->id;
                }
            });

            static::addGlobalScope('created_by_admin_id', function (Builder $builder)
            {
                if (Auth::guard()->check()  && Auth::guard()->user()->role == 'admin') {
                    return $builder->where('created_by_admin_id', Auth::guard()->user()->id);
                }
            });
        }
    }
}
