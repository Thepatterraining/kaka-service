<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVp extends Model
{
    use SoftDeletes;
    //
    protected $table = "sys_user_vp";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
