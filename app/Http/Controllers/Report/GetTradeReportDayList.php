<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportUserCoinDayData as ReportDayData;
use App\Http\Adapter\Report\ReportUserCoinDayAdapter as ReportDayAdapter;
use App\Http\Controllers\QueryController;

class GetTradeReportDayList extends QueryController
{

    public function getData()
    {
        return new \App\Data\Report\ReportTradeDayData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Report\ReportTradeDayAdapter;
    }
}
