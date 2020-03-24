<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;
    protected $table = "sys_coin_fee";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
