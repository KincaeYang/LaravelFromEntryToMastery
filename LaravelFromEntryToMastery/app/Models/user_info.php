<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;


class user_info extends Model
{
    use SoftDeletes;

    protected $table = 'user_info';

    public $timestamps = false;

    //访问频率限制，每分钟不超过2次
    protected $rate_limit = 2;

    //访问器一定要在对应的模型中设置
    public function getDisplayLevelAttribute()
    {
        return $this->level ? $this->level : 'P0';
    }


    //修改器
    public function setMobileAttribute($value)
    {
        return $this->attributes['mobile'] = encrypt($value);
    }

    public function getDisplayMobileAttribute()
    {
        $num = decrypt($this->mobile);
        $lastFour = mb_substr($num, -4);
        return '*** **** ' . $lastFour;
    }
}
