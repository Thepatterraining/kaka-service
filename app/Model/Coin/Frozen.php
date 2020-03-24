<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frozen extends Model
{
    use SoftDeletes;
    protected $table = "user_coin_frozen";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
