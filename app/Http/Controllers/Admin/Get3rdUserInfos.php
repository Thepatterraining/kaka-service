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
use App\Data\App\UserInfoData;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\App\AppInfoData;
use App\Http\Adapter\App\AppInfoAdapter;

class Get3rdUserInfos extends QueryController
{
    public function getData() 
    {
        return new UserInfoData();
    }

    public function getAdapter()
    {
        return new UserInfoAdapter();
    }

    protected function getItem($arr)
    {
        $userFac = new UserData();
        $userAdapter = new UserAdapter();
        $appInfoData = new AppInfoData;
        $appInfoAdapter = new AppInfoAdapter;
        $user = $userFac ->get($arr["kkuserid"]);
        $arr["kkuserid"]= $userAdapter->getDataContract($user);
        $app = $appInfoData->getByNo($arr['appid']);
        $arr['appid'] = $appInfoAdapter->getDataContract($app);
        return $arr;
    }
}
