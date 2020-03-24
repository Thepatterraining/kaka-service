<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashAccountData;
use App\Http\Adapter\Sys\CashAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSysCashAccounts extends QueryController
{

    public function getData()
    {
        return new  CashAccountData();
    }

    public function getAdapter()
    {
        return new CashAccountAdapter();
    }
}
