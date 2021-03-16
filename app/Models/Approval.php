<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use SearchTrait;
    protected $guarded = [
        'id'
    ];

    public function staff()
    {
        return $this->hasOne('App\Models\Staff', 'id', 'staff_id');
    }

    public function leave(){
        return $this->hasOne('App\Models\Leave', 'id', 'leave_id');
    }
}
