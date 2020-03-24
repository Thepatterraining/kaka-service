<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rechage extends Model
{
    use SoftDeletes;
    protected $table = "coin_rechage";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
