<?php

namespace App\Http\Controllers\Admin\Kyc;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Coin\CoinAddressInfoData;
use App\Http\Adapter\Coin\CoinAddressInfoAdapter;

/**
 * 查询认证地址列表
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date 2017.12.7
 */
class GetCoinAddress extends QueryController
{
    public function getData()
    {
        return new  CoinAddressInfoData;
    }

    public function getAdapter()
    {
        return new CoinAddressInfoAdapter;
    }
}
