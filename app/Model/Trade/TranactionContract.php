<?php

namespace App\Model\Trade;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranactionContract extends Model
{
    use SoftDeletes;
    protected $table = "transaction_contract";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
