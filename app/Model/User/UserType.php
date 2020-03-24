<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;
    //
    protected $table = "sys_user_type";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
