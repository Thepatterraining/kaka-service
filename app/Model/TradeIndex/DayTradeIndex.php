<?php

namespace App\Model\TradeIndex;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayTradeIndex extends Model
{
    use SoftDeletes;
    protected $table = "index_coin_day";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
