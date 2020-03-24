<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\CashJournalData;
use App\Http\Adapter\Sys\CashJournalAdapter;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSysCashJournalList extends QueryController
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
