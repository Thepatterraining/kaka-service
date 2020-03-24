<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\FrozenData;
use App\Http\Adapter\Coin\FrozenAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCoinFrozenListt extends Controller
{
    public function run()
    {
        $data = new FrozenData();
        $adapter = new FrozenAdapter();

        $request = $this->request->all();
        $coinType = $request['coinType'];
        $userid = $this->session->userid;

        $filter['filters']['userid'] = $userid;
        $filter['filters']['cointype'] = $coinType;
        $filters = $adapter->getFilers($filter);
        $item = $data->getCoinList($filters, $pageSize, $pageIndex);
    }
}
