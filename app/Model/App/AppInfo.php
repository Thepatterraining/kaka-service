<?php

namespace App\Model\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppInfo extends Model
{
    protected $table = "3rd_app_info";
    protected $dates = ["created_at","updated_at"];
}
