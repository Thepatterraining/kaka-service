<?php

namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayJournal extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_3rd_pay_journal";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
