<?php

namespace App\Model\TradeIndex;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HourTradeIndex extends Model
{
    use SoftDeletes;
    protected $table = "index_coin_hour";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
