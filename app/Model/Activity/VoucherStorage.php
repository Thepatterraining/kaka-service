<?php

namespace App\Model\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherStorage extends Model
{
    use SoftDeletes;
    protected $table = "voucher_storage";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
