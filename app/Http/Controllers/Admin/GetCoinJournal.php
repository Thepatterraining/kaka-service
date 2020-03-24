<?php

namespace App\Http\Controllers\Admin;

use App\Data\User\CoinJournalData;
use App\Http\Adapter\User\CoinJournalAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCoinJournal extends QueryController
{

    public function getData()
    {
        return new  CoinJournalData();
    }

    public function getAdapter()
    {
        return new CoinJournalAdapter();
    }
}
