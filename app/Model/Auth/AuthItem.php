<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthItem extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_auth_authitem";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
