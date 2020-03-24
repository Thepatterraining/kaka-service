<?php
namespace App\Data\Report;

use App\Data\Report\IReportData;
use App\Data\Sys\UserData;
use App\Data\Schedule\IDaySchedule;

/**
 * 报表输出
 */
class ReportSumsDayData extends IReportSumsDayData implements IDaySchedule
{
    protected $userAdapter = "App\Http\Adapter\Sys\UserAdapter";
    protected $userData = "App\Data\Sys\UserData";
    protected $reportAdapter = "App\Http\Adapter\Report\ReportSumsDayAdapter";
    // protected $noPre = "SCR";
    protected $reportData="App\Data\Report\ReportSumsDayData";
    protected $modelclass = "App\Model\Report\ReportSumsDay";
    //protected $no = "reportment_no";

    function maxIdByTime()
    {
        $model=$this->newitem();
        $res=$model->orderBy('report_end', 'desc')->skip(1)->first();
        return $res;
    }

    function getLastReportCommon()
    {
        $model=$this->newitem();
        $res=$model->orderBy('report_end', 'desc')->first();
        return $res;
    }

    public function makeAllReportHourReport()
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

    public function makeAllDayReport()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDayReport();
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    public function makeHistoryDayReport()
    {
        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
           
                $this->makeReport($start, $end, $this::$USER);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
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
        $this->makeDayReport();
        return true;
    }
}


