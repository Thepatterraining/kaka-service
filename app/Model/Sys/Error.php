<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Error extends Model
{
    //
        use SoftDeletes;
    protected $table = "sys_error";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
