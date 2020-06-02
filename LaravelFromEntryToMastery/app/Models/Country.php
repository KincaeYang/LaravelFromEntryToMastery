<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\user_info;
use App\Models\Users;

class Country extends Model
{

    protected $table = 'countries';
    //远成一对多关联
    public function user_info()
    {
        return $this->hasManyThrough(user_info::class,Users::class,'country_id','uid');
    }
}
