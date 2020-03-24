<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
use App\Http\Controllers\QueryController;

class GetUserrbReportDayList extends QueryController
{
    public function getData()
    {
        return new \App\Data\Report\ReportUserrbSubDayData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
    }
}
