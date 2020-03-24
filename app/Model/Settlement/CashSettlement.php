<?php

namespace App\Model\Settlement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashSettlement extends Model
{
    //
    use SoftDeletes;
    protected $table = "settlement_cash";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
