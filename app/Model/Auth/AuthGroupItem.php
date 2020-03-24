<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthGroupItem extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_auth_members";
    protected $dates = ["created_at","updated_at","deleted_at"];

    public function authGroup()
    {
        return $this->hasMany('App\Model\Auth\AuthGroup', 'id', 'group_id');
    }
}
