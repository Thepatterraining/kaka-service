<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_3rd_account";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
