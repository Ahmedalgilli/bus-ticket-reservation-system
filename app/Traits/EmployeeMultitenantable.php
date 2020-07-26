<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait EmployeeMultitenantable
{
    public static function bootEmployeeMultitenantable()
    {
        if (Auth::guard()->check()) {
            static::creating(function($model)
            {
                if (Auth::guard()->user()->role == 'employee') {
                    $model->created_by_employee_id = Auth::guard()->user()->id;
                    $model->user_id = Auth::guard()->user()->manager->id;
                }
            });

            static::addGlobalScope('created_by_employee_id', function (Builder $builder)
            {
                if (Auth::guard()->check() && Auth::guard()->user()->role == 'employee') {
                    return $builder->where(['created_by_employee_id' => Auth::guard()->user()->id, 'user_id' => Auth::guard()->user()->manager->id]);
                }
            });
        }
    }
}
