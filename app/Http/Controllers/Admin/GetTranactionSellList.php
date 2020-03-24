<?php

namespace App\Http\Controllers\Admin;

use App\Data\Item\InfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class GetTranactionSellList extends QueryController
{

    public function getData()
    {
        return new  TranactionSellData();
    }

    public function getAdapter()
    {
        return new TranactionSellAdapter();
    }

    protected function getItem($arr)
    {
        $itemData = new InfoData();
        $orderData = new TranactionOrderData();
        $userFac = new UserData();
        $userAdaper = new UserAdapter();
        $arr['item'] = $itemData->getInfo($arr['cointype']);
            $arr['order'] = $orderData->getInfo($arr['cointype']);

            $user = $userFac ->get($arr["userid"]);
            $arr["userid"]= $userAdaper->getDataContract($user);
            return $arr;
    }
}
