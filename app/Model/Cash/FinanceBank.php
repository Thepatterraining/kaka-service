<?php

namespace App\Model\Cash;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class financeBank extends Model
{
    //
    use SoftDeletes;
    protected $table = "finance_bank";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
