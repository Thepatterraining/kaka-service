<?php

namespace App\Model\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherInfo extends Model
{
    use SoftDeletes;
    protected $table = "voucher_info";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
