<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportSumsHourData;

class MakeHourReport extends Controller
{
    //
    protected function run()
    {



        $fac = new ReportSumsHourData();

        $item = $fac->makAllReportHour(1);
        if ($item!=false) {
            $this->Success($item);
        } else {
            $this->Error(808001);
        }
    }
}
