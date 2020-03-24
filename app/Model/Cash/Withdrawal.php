<?php

namespace App\Model\Cash;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    //
    use SoftDeletes;
    protected $table = "cash_withdrawal";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
