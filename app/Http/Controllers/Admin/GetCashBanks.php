<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\BankAccountData;
use App\Http\Adapter\Sys\CashBankAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCashBanks extends QueryController
{
    public function getData()
    {
        return new  BankAccountData();
    }

    public function getAdapter()
    {
        return new CashBankAccountAdapter();
    }
}
