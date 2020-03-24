<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportTradeDayData;

class ReportTradeData implements IDaySchedule
{
    //
    public function run()
    {
        $ReportTradeDayData=new ReportTradeDayData();
        $ReportTradeDayData->makeDayReport();
        return true;
    }
}