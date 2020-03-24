<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportWithdrawalDayData;

class ReportWithdrawalData implements IDaySchedule
{
    //
    public function run()
    {
        $ReportWithdrawalDayData=new ReportWithdrawalDayData();
        $ReportWithdrawalDayData->makeDayReport();
        return true;
    }
}