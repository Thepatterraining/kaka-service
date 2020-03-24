<?php

namespace App\Model\Settlement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysCashSettlement extends Model
{
    //
    use SoftDeletes;
    protected $table = "settlement_sys_cash";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
