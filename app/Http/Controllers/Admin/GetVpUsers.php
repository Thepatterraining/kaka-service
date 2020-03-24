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
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\User\UserVpData;
use App\Http\Adapter\User\UserVpAdapter;

class GetVpUsers extends QueryController
{

    public function getData()
    {
        return new  UserVpData();
    }

    public function getAdapter()
    {
        return new UserVpAdapter();
    }

    protected function getItem($arr)
    {
        $userFac = new UserData();
        $userAdaper = new UserAdapter();
        $user = $userFac ->get($arr["userid"]);
            $arr["userid"]= $userAdaper->getDataContract($user);
        return $arr;
    }
}
