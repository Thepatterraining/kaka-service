<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportHourData;
use App\Http\Adapter\Report\ReportHourAdapter;
use App\Http\Controllers\QueryController;

class GetReportHourList extends QueryController
{
    public function getData()
    {
        return new \App\Data\Report\ReportUserSumsHourData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Report\ReportUserSumsHourAdapter;
    }
}
