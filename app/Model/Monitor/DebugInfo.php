<?php

namespace App\Model\Monitor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebugInfo extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_debug";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
