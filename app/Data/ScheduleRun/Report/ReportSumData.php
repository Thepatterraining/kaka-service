<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportSumsDayData;

class ReportSumData implements IDaySchedule
{
    //
    public function run()
    {
        $ReportSumsDayData=new ReportSumsDayData();
        $ReportSumsDayData->makeDayReport();
        return true;
    }
}