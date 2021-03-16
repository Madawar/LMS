<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use SearchTrait;

    protected $guarded = [
        'id'
    ];

    public function raiser()
    {
        return $this->hasOne('App\Models\Staff', 'id', 'staff_id');
    }

    public function approvers()
    {
        return $this->hasMany('App\Models\Approval','leave_id');
    }
}
