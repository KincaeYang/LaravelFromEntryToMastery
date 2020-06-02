<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserProfile;
use App\Models\Tag;

class Users extends Model
{
//    protected $connection = '';

    protected $table = 'users';


    /**
     * hasOne('参一：模型名称','参二：外键','参三')
     *
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class,'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'user_tags','user_id');
    }

}
