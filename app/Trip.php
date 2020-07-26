<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EmployeeMultitenantable;

class Trip extends Model
{
    use EmployeeMultitenantable;
    
    protected $guarded = [];

    // public function buses()
    // {
    //     return $this->hasMany(Bus::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by_employee_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
