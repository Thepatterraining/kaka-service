<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    use SoftDeletes;
    protected $table = "coin_withdrawal";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
