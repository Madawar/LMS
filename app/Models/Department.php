<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use SearchTrait;
    protected $guarded = [
        'id'
    ];

    public function manager()
    {
        return $this->hasOne('App\Models\Staff','id','department_manager');
    }
}
