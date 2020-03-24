<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Schedule\IMonthSchedule;
use App\Data\Report\ReportSettlementDayListData;

class ReportSettlementData implements IDaySchedule,IMonthSchedule
{
    //
    public function run()
    {
        $date=date("Y-m-d");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $reportSettlementDayListData=new ReportSettlementDayListData();
        $reportSettlementDayListData->historyrun($start, $end, $date);
        return true;
    }

    public function hourrun()
    {
        $date=date("Y-m-d H:00:00");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 hours"));
        $reportSettlementDayListData=new ReportSettlementDayListData();
        $reportSettlementDayListData->historyrun($start, $end, $date);
        return true;
    }

    public function monthrun()
    {
        $date=date("Y-m-1");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 month"));
        $reportSettlementDayListData=new ReportSettlementDayListData();
        $reportSettlementDayListData->historyrun($start, $end, $date);
        return true;
    }
}