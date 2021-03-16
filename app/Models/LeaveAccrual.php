<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;

class LeaveAccrual extends Model
{
    use SearchTrait;
    protected $guarded = [
        'id'
    ];
}
