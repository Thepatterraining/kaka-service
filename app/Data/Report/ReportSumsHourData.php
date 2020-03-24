<?php
namespace App\Data\Report;

use App\Data\Report\IReportData;
use App\Data\Sys\UserData;
use App\Data\Schedule\IHourSchedule;

/**
 * 报表输出
 */
class ReportSumsHourData extends IReportSumsHourData implements IHourSchedule
{
    protected $userAdapter = "App\Http\Adapter\Sys\UserAdapter";
    protected $userData = "App\Data\Sys\UserData";
    protected $reportAdapter = "App\Http\Adapter\Report\ReportSumsHourAdapter";
    // protected $noPre = "SCR";
    protected $reportData="App\Data\Report\ReportSumsHourData";
    protected $modelclass = "App\Model\Report\ReportSumsHour";
    //protected $no = "reportment_no";

    function maxIdByTime($start)
    {
        $model=$this->newitem();
        $res=$model->where('report_end', $start)->first();
        return $res;
    }

    public function makeAllUserHourReport()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeHourReport();
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    public function makeAllUserReport()
    {


  
        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        /*       while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
           
                $this->makeReport($start,$end,$this::$USER);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }*/
        return $result;
    }
    public function getReport()
    {
        $model=$this->newitem();
        $res=$model->select(
            "report_name",
            "report_intcount",
            "report_acscount",
            "report_currentcount",
            "report_lastlogin",
            "report_acslogin",
            "report_currentlogin",
            "report_start",
            "report_end"
        )->get();
        return $res;
    }

    public function run()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeHourReport();
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }
}


