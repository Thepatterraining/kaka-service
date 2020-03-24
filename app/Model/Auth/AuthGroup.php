<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthGroup extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_auth_group";
    protected $dates = ["created_at","updated_at","deleted_at"];

    public function authUser()
    {
        return $this->belongsToMany('App\Model\Auth\User', 'App\Model\Auth\AuthGroupItem', 'group_id', 'authuser_id');
    }

    public function auth()
    {
        return $this->belongsToMany('App\Model\Auth\Item', 'sys_auth_authitem', 'group_id', 'auth_id');
    }
}
