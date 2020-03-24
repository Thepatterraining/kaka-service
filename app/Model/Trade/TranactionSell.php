<?php

namespace App\Model\Trade;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranactionSell extends Model
{
    use SoftDeletes;
    protected $table = "transaction_sell";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
