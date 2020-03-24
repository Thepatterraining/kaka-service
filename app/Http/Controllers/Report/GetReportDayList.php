<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Adapter\Report\ReportSumsDayAdapter;
use App\Http\Controllers\QueryController;
use App\Data\Report\ReportSumsDayData;

class GetReportDayList extends QueryController
{

    public function getData()
    {
        return new ReportSumsDayData;
    }

    public function getAdapter()
    {
        return new  ReportSumsDayAdapter;
    }
}
