<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportSumsDayData;

class MakeDayReport extends Controller
{
    //
    protected function run()
    {

        $fac = new ReportSumsDayData();

        $item = $fac->makeAllReportDay(1);
        if ($item!=false) {
            $this->Success($item);
        } else {
            $this->Error(808001);
        }
    }
}
