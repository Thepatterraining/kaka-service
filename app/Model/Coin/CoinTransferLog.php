<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 代币转让记录表 model
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.13
 */
class CoinTransferLog extends Model
{
    use SoftDeletes;
    protected $table = "coin_transfer_log";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
