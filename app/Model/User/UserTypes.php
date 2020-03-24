<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypes extends Model
{
    use SoftDeletes;
    //
    protected $table = "sys_user_types";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
