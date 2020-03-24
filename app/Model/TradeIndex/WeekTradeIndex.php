<?php

namespace App\Model\TradeIndex;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeekTradeIndex extends Model
{
    use SoftDeletes;
    protected $table = "index_coin_week";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
