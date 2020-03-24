<?php

namespace App\Http\Controllers\Admin;

use App\Data\Settlement\ReportSettlementData;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Cash\JournalAdapter;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetReportSettlementList extends QueryController
{

    public function getData()
    {
        return new  ReportSettlementData();
    }

    public function getAdapter()
    {
        return new ReportSettlementAdapter();
    }
}
