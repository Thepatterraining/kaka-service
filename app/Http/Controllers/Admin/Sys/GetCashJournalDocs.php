<?php

namespace App\Http\Controllers\Admin\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;

class GetCashJournalDocs extends QueryController
{

    public function getData()
    {
        return new CashJournalDocData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Sys\CashJournalDocAdapter;
    }
}
