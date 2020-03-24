<?php

namespace App\Http\Controllers\Admin;

use App\Data\Settlement\CashSettlementData as DataFac;
use App\Http\Adapter\Settlement\SysCashAdapter as DataAdpter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;

class GetSettlementCashList extends QueryController
{

    public function getData()
    {
        return new  DataFac();
    }

    public function getAdapter()
    {
        return new DataAdpter();
    }
}
