<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model as SysModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends SysModel
{
    //
    use SoftDeletes;
    protected $table = "sys_model";
    protected $dates = ["created_at","updated_at","deleted_at"];
}