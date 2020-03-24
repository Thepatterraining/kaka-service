<?php

namespace App\Http\Controllers\Admin;

use App\Data\Settlement\SysCashSettlementData as DataFac;
use App\Http\Adapter\Settlement\SysCashAdapter as DataAdpter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSettlementSysCashList extends QueryController
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
