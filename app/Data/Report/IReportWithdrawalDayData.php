<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportWithdrawalDayData;

abstract class IReportWithdrawalDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $withdrawalData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportWithdrawalDay';

    abstract protected function getLastReport();
    
    //去掉redis锁 2017.9.5 liu
    public function makeReport($start, $end, $reportType)
    {
                        
        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();
             
        
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $userData = new $this->userData();
        $userAdapter = new $this->userAdapter();
        $withdrawalData = new $this->withdrawalData();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
            "filters"=>[
            "begin"=>$startd,
            "end"=>$endd
            ]
        ];
        
        $queryfilter = $reportAdapter->getFilers($reportfilter);
        // 
        //($queryfilter);
        $items = $this->query($queryfilter, 1, 1);
        //dump($items["totalSize"]);
        if ($items["totalSize"]>0) {
            return ;
        }
        // if ($lk->lock($lockKey)===false) {
        //     return ;
        // }
        $rptModel = $this->newitem();
        $rpt = array();
        $rpt["runtype"] = $reportType;
        
        //$rpt["no"] = DocNoMaker::Generate($this->noPre);
        $rpt ["begin"] = $startd;
        $rpt["end"] = $endd;
        //$rpt["accountid"] = $accountid;
        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->create($rptModel);
        
        $rpt = $reportAdapter->getDataContract($rptModel, null, true);
        $status = $this->getLastReport();
        if(empty($status)) {
            $initCount=0;
            $initInv=0;
            $initCash=0;
            $initUncheckCount=0;
        }
        else
        {
            $initCount=$status->report_resultcount;
            $initInv=$status->report_resultinv;
            $initCash=$status->report_resultcash;
            $initUncheckCount=$status->report_resultuncheckcount;
            $rpt["start"]=$status->report_end;
            $start=$status->report_end;
        }   

        $withdrawalCount = $withdrawalData->getWithdrawalCountDaily($start, $end);
        $withdrawalCash = $withdrawalData->getCashCountDaily($start, $end);
        $withdrawalUncheckCount = $withdrawalData->getUncheckCountDaily($end);
        //$resultInv =$withdrawalData->getInvCountDaily($start,$end);
        $resultInv = 0;

        $rpt['no']=DocNoMaker::Generate("RUWD");
        $rpt["name"]=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";//"from" + $startd + "to" + $endd;
        $rpt["runtype"]=$reportType;

        $rpt["initCount"]=$initCount;
        $rpt["withdrawalCount"]=$withdrawalCount;
        $rpt["resultCount"]=$withdrawalCount+$initCount;

        $rpt["initCash"]=$initCash;
        $rpt["withdrawalCash"]=$withdrawalCash;
        $rpt["resultCash"]=$withdrawalCash+$initCash;

        $rpt["initInv"]=$initInv;
        $rpt["withdrawalInv"]=$resultInv-$initInv;
        $rpt["resultInv"]=$resultInv;

        $rpt["initUncheckCount"]=$initUncheckCount;
        $rpt["withdrawalUncheckCount"]=$withdrawalUncheckCount-$initUncheckCount;
        $rpt["resultUncheckCount"]=$withdrawalUncheckCount;

        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->save($rptModel);
        // $lk->unlock($lockKey);
        return $rpt;
    }
    
    
    public function makeDayReport()
    {
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        // date_add($start, date_interval_create_from_date_string("-1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');
        $reportWithdrawalDayData=new ReportWithdrawalDayData();
        $start=$reportWithdrawalDayData->getLastReportCommon()->report_end;
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        // dump($tmp_end);
        while(strtotime($tmp_end)<=strtotime($end))
        {
            dump($tmp_end);
            $this->makeReport($tmp_start, $tmp_end, $this::$DAY);
            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }
        return true;
        // return $this->makeReport($start, $end, $this::$DAY);
    }

}
