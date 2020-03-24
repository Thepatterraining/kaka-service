<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportSurveyDayListData;

class ReportSurveyData implements IHourSchedule
{
    //
    public function run()
    {
        $date=date("Y-m-d");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $reportSurveyDayListData=new ReportSurveyDayListData();
        $reportSurveyDayListData->historyrun($start, $end, $date);
        return true;
    }

    public function hourrun()
    {
        $date=date("Y-m-d H:00:00");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 hours"));
        $reportSurveyDayListData=new ReportSurveyDayListData();
        $reportSurveyDayListData->historyrun($start, $end, $date);
        return true;
    }
}