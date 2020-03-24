<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginLog extends Model
{
    //
    use SoftDeletes;
    protected $table = "auth_login_log";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
