<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportSumsDayData;
use App\Data\Report\ReportRechargeItemDayData;
use App\Data\Sys\UserData;

class ReportRechargeItemData implements IDaySchedule
{
    public function run()
    {

        //return 1;
        $userFac = new UserData();
        $reportRechargeItemDayData=new ReportRechargeItemDayData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                $reportRechargeItemDayData->makeDayReport($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }
}