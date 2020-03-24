<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinAccount extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_coin_account";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
