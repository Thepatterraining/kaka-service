<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportUserCoinDayData as ReportDayData;
use App\Http\Adapter\Report\ReportUserCoinDayAdapter as ReportDayAdapter;
use App\Http\Controllers\QueryController;

class GetRechargeReportDayList extends QueryController
{

    public function getData()
    {
        return new \App\Data\Report\ReportRechargeDayData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Report\ReportRechargeDayAdapter;
    }
}
