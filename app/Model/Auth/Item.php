<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_auth_item";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
