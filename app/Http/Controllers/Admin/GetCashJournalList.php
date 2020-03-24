<?php

namespace App\Http\Controllers\Admin;

use App\Data\Cash\JournalData;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Cash\JournalAdapter;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCashJournalList extends QueryController
{
    public function getData()
    {
        return new  JournalData();
    }

    public function getAdapter()
    {
        return new JournalAdapter();
    }
}
