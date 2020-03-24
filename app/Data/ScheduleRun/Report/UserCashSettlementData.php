<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Sys\UserData;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionBuyData;

class ReportUserrbSubData implements IDaySchedule
{

    public function run()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDaySettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    public function hourrun()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
            
                $this->makeHourSettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }
}