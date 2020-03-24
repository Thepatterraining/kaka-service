<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionBuyData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionBuyAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class GetTranactionBuyList extends QueryController
{
    public function getData()
    {
        return new  TranactionBuyData();
    }

    public function getAdapter()
    {
        return new TranactionBuyAdapter();
    }

    protected function getItem($arr)
    {
        $userFac = new UserData();
        $userAdaper = new UserAdapter();
        $user = $userFac ->  get($arr["userid"]);
            $arr["userid"]= $userAdaper->getDataContract($user);
            return $arr;
    }
}
