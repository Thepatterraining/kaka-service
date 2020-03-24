<?php

namespace App\Model\Coin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 地址认证信息表 model
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.7
 */
class CoinAddressInfo extends Model
{
    use SoftDeletes;
    protected $table = "coin_addressinfo";
    protected $dates = ["created_at","updated_at","deleted_at"];
}
