<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportRechargeDayData;
use App\Data\Report\ReportRechargeItemDayData;
use Illuminate\Support\Facades\DB;

abstract class IReportRechargeDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $rechargeData = "";
    protected $payChannelData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportRechargeDay';

    abstract protected function getLastReport();
    
    //去掉redis锁 2017.9.5 liu
    public function makeReport($start, $end, $reportType)
    {
                        
        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();
        
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $userData = new $this->userData();//UserData();
        $userAdapter = new $this->userAdapter();
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

        $status = $this->getLastReport();

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

        $rechargeData=new $this->rechargeData();
        $rechargeCount = $rechargeData->getUserRechargeCountDaily($start, $end);
        $rechargeCash = $rechargeData->getCashCountDaily($start, $end);
        //$rechargeUncheckCount = $rechargeData->getUncheckCountDaily($end);
        $rechargeInvInfo =$rechargeData->getInvCountDaily($start, $end);
        $rechargeInv = $rechargeInvInfo[0]->count;

        $rpt['no']=DocNoMaker::Generate("RUR");
        $rpt["name"]=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";//"from" + $startd + "to" + $endd;
        $rpt["runtype"]=$reportType;   

        $rpt["initCount"]=$rechargeData->newitem()->where('cash_recharge_success', 1)->where('created_at', '<=', $start)->count();
        $rpt["rechargeCount"]=$rechargeCount;
        $rpt["resultCount"]=$rechargeCount+$rpt["initCount"];

        $rpt["initCash"]=$initCash;
        $rpt["rechargeCash"]=$rechargeCash;
        $rpt["resultCash"]=$rechargeCash+$initCash;

        // $initInvInfo=DB::select('select count(distinct cash_recharge_userid) as count from cash_recharge where cash_recharge_success = 1 and created_at <= ?',[$start]);
        $rpt["initInv"]=$initInv;
        $rpt["rechargeInv"]=$rechargeInv;
        $rpt["resultInv"]=$initInv+$rechargeInv;


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
        
        // $reportRechargeDayData=new ReportRechargeDayData();
        $userData=new $this->userData();
        $payChannelData=new $this->payChannelData();
        $reportRechargeDayData=new ReportRechargeDayData();
        $reportRechargeItemDayData=new ReportRechargeItemDayData();

        $start=$reportRechargeDayData->getLastReportCommon()->report_end;
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        // dump($tmp_end);
        while(strtotime($tmp_end)<=strtotime($end))
        {
            dump($tmp_end);
            $res=$this->makeReport(
                $tmp_start, $tmp_end,
                'CYC01'
            );
            $item=$reportRechargeDayData->getById($res['start']);
            $tmp=$payChannelData->getClassAll();

            if($item != null) {
                foreach($tmp as $value)
                {
                    $reportRechargeItemDayData->makeReport($item->report_no, $value->id);
                }
            }
            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }
        
       
        return 0;
    }

}
