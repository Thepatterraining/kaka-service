<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationRelease extends Model
{
    use SoftDeletes;
    protected $table = "sys_applicationrelease";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
