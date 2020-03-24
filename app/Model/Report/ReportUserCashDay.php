<?php

namespace App\Model\Report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportUserCashDay extends Model
{
    //
    use SoftDeletes;
    protected $table = "report_user_cash_day";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
