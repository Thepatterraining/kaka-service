<?php

namespace App\Http\Controllers\Auth;

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
use App\Data\Activity\GroupData;
use App\Http\Adapter\Activity\GroupAdapter;

class GetAuthGroups extends QueryController
{

    public function getData()
    {
        return new  \App\Data\Auth\AuthGroupData();
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Auth\AuthGroupAdapter();
    }
}
