<?php

namespace App\Model\Trade;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranactionBuy extends Model
{
    use SoftDeletes;
    protected $table = "transaction_buy";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
