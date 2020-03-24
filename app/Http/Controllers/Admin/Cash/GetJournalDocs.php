<?php

namespace App\Http\Controllers\Admin\Cash;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;
use App\Data\Cash\JournalDocData;

class GetJournalDocs extends QueryController
{
    public function getData()
    {
        return new JournalDocData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Cash\JournalDocAdapter;
    }
}
