<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportRechargeDayData;

class ReportSumData implements IDaySchedule
{
    //
    public function run()
    {
        $reportRechargeDayData=new ReportRechargeDayData();
        $reportRechargeDayData->makeDayReport();
        return true;
    }
}