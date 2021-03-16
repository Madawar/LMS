<?php

namespace App\Models;


use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;
    use SearchTrait;

    protected $guarded = [
        'id'
    ];

    public function department()
    {
        return $this->hasOne('App\Models\Department','id','department');
    }

    public function dep()
    {
        return $this->hasOne('App\Models\Department','id','department');
    }


    protected $dates = [
        'dateOfEmployment',
    ];

    public function user(){
        return $this->hasOne('App\Models\User','pno','pno');
    }

}
