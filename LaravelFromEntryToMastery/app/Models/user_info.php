<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_info extends Model
{
    use SoftDeletes;

    protected $table = 'user_info';

    public $timestamps = false;
    //访问频率限制，每分钟不超过2次
    protected $rate_limit = 2;


}
