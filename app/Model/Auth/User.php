<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class User extends Model
{
    //
    use SoftDeletes;
    protected $table = "auth_user";
    protected $dates = ["created_at","updated_at","deleted_at"];

    public function authGroup()
    {
        return $this->belongsToMany('App\Model\Auth\AuthGroup', 'sys_auth_members', 'authuser_id', 'group_id');
    }
}
