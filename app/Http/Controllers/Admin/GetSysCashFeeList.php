<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashFeeData;
use App\Http\Adapter\Sys\CashFeeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;

class GetSysCashFeeList extends QueryController
{

    public function getData()
    {
        return new  CashFeeData();
    }

    public function getAdapter()
    {
        return new CashFeeAdapter();
    }
}
