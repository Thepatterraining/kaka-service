<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportRechargeItemDayData;
use App\Data\Report\ReportRechargeDayData;

abstract class IReportRechargeItemDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $rechargeData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected $payChannelData="";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportRechargeItemDay';

    abstract protected function getLastReport($rechargeType);
    //abstract protected function getSelfLastReport($start);

    //去掉redis锁 2017.9.5 liu
    public function makeReport($no, $rechargeType)
    {
        $reportData=new ReportRechargeDayData();
        $reportInfo=$reportData->getByNo($no);
        $userId=$reportInfo->report_user;
        $start=$reportInfo->report_start;
        $end=$reportInfo->report_end;

        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();
             
        
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $userData = new $this->userData();//UserData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        $payChannelData=new $this->payChannelData();
        
        $reportfilter =[
            "filters"=>[
            "no"=>$no,
            "type"=>$rechargeType
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
        $rpt["type"] = $rechargeType;
        
        //$rpt["no"] = DocNoMaker::Generate($this->noPre);
        $rpt["date"] = $startd;
        //$rpt["accountid"] = $accountid;
        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->create($rptModel);
        
        $rpt = $reportAdapter->getDataContract($rptModel, null, true);

        $status = $this->getLastReport($rechargeType);
        // dump($status);
        if(empty($status)) {
            $initCount=0;
            $initInv=0;
            $initCash=0;
        }

        else
        {
            $initCount=$status->report_resultcount;
            $initInv=$status->report_resultinv;
            $initCash=$status->report_resultcash;
            // $rpt['start']=$status->report_end; 
            // $start=$status->report_end;
        }  

        $rechargeData=new $this->rechargeData();
        $rechargeCount = $rechargeData->getRechargeItemCountDaily($start, $end, $rechargeType);
        $rechargeCash = $rechargeData->getRechargeItemCashCountDaily($start, $end, $rechargeType);
        //$rechargeUncheckCount = $rechargeData->getUncheckCountDaily($end);
        $resultInvInfo =$rechargeData->getRechargeItemInvCountDaily($start, $end, $rechargeType);
        $resultInv = $resultInvInfo[0]->count;
        //$resultInv = 0;

        $rpt['no']=$no;
        $rpt["name"]=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";//"from" + $startd + "to" + $endd;
        $rpt["type"]=$rechargeType;

        $rpt["rechargeChannelId"]=$rechargeType;
        $rpt["type"]=$payChannelData->getClassName($rechargeType);

        $rpt["initCount"]=$initCount;
        $rpt["rechargeCount"]=$rechargeCount;
        $rpt["resultCount"]=$rechargeCount+$initCount;

        $rpt["initCash"]=$initCash;
        $rpt["rechargeCash"]=$rechargeCash;
        $rpt["resultCash"]=$rechargeCash+$initCash;

        $rpt["initInv"]=$initInv;
        $rpt["rechargeInv"]=$resultInv-$initInv;
        $rpt["resultInv"]=$resultInv;

        $rpt["start"]=$start;
        $rpt["end"]=$end;

        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->save($rptModel);
        // $lk->unlock($lockKey);
        return $rpt;
    }
    
    
    public function makeDayReport()
    {
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
        return $this->makeReport($start, $end, $this::$DAY);
    }

}
