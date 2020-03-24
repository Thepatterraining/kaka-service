<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportTradeDayData;

abstract class IReportTradeDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $tranactionData = "";
    protected $tranactionBuyData="";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportTradeDay';

    abstract protected function getLastReport($end);
    
    //2017.8.17 调整报表参数 liu
    //去掉redis锁 2017.9.5 liu
    public function makeReport($start, $end, $reportType)
    {
                        
        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();
             
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        $userData = new $this->userData();
        $userAdapter = new $this->userAdapter();
        $tranactionData = new $this->tranactionData();
        $tranactionBuyData = new $this->tranactionBuyData();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
            "filters"=>[
            "start"=>$startd,
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
        $status = $this->getLastReport($end);
        // dump($status);
        // return ;
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
            $rpt['start']=$status->report_end;
            $start=$status->report_end; 
        } 

        $tradeCount = $tranactionData->getTradeCountDaily($start, $end);
        $tradeCash = $tranactionData->getCashCountDaily($start, $end);
        $resultInvInfo = $tranactionData->getInvCountDaily($start, $end);
        $resultInv = $resultInvInfo[0]->count;


        $rpt["no"]=DocNoMaker::Generate("RUT");
        $rpt["name"]=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";//"from" + $startd + "to" + $endd;
        //$rpt["runtype"]=$reportType;

        $rpt["initCount"]=$tranactionData->newitem()->where('created_at', '<=', $start)->count();
        $rpt["tradeCount"]=$tradeCount;
        $rpt["resultCount"]=$tradeCount+$rpt["initCount"];

        $rpt["initCash"]=$tranactionData->newitem()->where('created_at', '<=', $start)->sum('order_amount');
        $rpt["tradeCash"]=$tradeCash;
        $rpt["resultCash"]=$tradeCash+$rpt["initCash"];

        $rpt["initInv"]=$initInv;
        $rpt["tradeInv"]=$resultInv-$initInv;
        $rpt["resultInv"]=$resultInv;

        $tranactionInfo=$tranactionData->newitem()->where('created_at', '<=', $start)->get();
        $rpt["initTopCount"]=0;
        $rpt["initTopCash"]=0;
        $rpt["initSecondCount"]=0;
        $rpt["initSecondCash"]=0;
        foreach($tranactionInfo as $tranactionItem)
        {
            $levelType=$tranactionBuyData->getLevelType($tranactionItem->order_buy_no);
            //一级市场判断
            if($levelType=='BL01') {
                $rpt["initTopCount"]++;
                $rpt["initTopCash"]+=$tranactionItem->order_amount;
            }
            //二级市场判断 
            else if($levelType=='BL00') {
                $rpt["initSecondCount"]++;
                $rpt["initSecondCash"]+=$tranactionItem->order_amount;
            }
            else
            {
                continue;
            }
        }

        $tranactionTradeInfo=$tranactionData->newitem()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
        $rpt["tradeTopCount"]=0;
        $rpt["tradeTopCash"]=0;
        $rpt["tradeSecondCount"]=0;
        $rpt["tradeSecondCash"]=0;
        foreach($tranactionTradeInfo as $tranactionTradeItem)
        {
            $levelType=$tranactionBuyData->getLevelType($tranactionTradeItem->order_buy_no);
            if($levelType=='BL01') {
                $rpt["tradeTopCount"]++;
                $rpt["tradeTopCash"]+=$tranactionTradeItem->order_amount;
            }
            else if($levelType=='BL00') {
                $rpt["tradeSecondCount"]++;
                $rpt["tradeSecondCash"]+=$tranactionTradeItem->order_amount;
            }
            else
            {
                continue;
            }
        }
        $rpt["resultTopCount"]=$rpt["initTopCount"]+$rpt["tradeTopCount"];
        $rpt["resultTopCash"]=$rpt["initTopCash"]+$rpt["tradeTopCash"];
        $rpt["resultSecondCount"]=$rpt["initSecondCount"]+$rpt["tradeSecondCount"];
        $rpt["resultSecondCash"]=$rpt["initSecondCash"]+$rpt["tradeSecondCash"];

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
        
        $reportTradeDayData=new ReportTradeDayData();
        $start=$reportTradeDayData->getLastReportCommon()->report_end;
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        // dump($tmp_end);
        while(strtotime($tmp_end)<=strtotime($end))
        {
            $this->makeReport($tmp_start, $tmp_end, $this::$DAY);
            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }
        return true;
    }

}
