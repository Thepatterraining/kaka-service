<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_config";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
