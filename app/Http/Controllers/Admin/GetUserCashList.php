<?php

namespace App\Http\Controllers\Admin;

use App\Data\User\CashJournalData;
use App\Http\Adapter\User\CashJournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetUserCashList extends QueryController
{

    public function getData()
    {
        return new  CashJournalData();
    }

    public function getAdapter()
    {
        return new CashJournalAdapter();
    }
}
