<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class Tag extends Model
{
    protected $table = 'tags';


    /**
     * 与tags表对应的关联关系
     */
    public function users()
    {
        return $this->belongsToMany(Users::class,'user_tags','tag_id','user_id');
    }
}
