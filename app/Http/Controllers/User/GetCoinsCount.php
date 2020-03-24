<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\User\CoinAccountAdapter;

class GetCoinsCount extends Controller
{
    /**
     * 查询我的房产的数量
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new CoinAccountData();
        $adapter = new CoinAccountAdapter();

        $count = $data->getUserCoinCounts();

        return $this->Success($count);
    }
}
