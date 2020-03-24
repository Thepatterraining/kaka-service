<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Sys\ErrorData;
use App\Data\Report\ReportUserrbSubDayData;

abstract class IReportUserrbSubDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected $tranactionData="";
    protected $invitationData="";
    protected $rakeBackTypeData="";
    protected $rebateData="";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportUserrbSubDay';

    abstract protected function getLastReport($userId,$start);
    
    //去掉redis锁 2017.9.5 liu
    public function createReport($userId,$start,$end,$reportType,$sts)
    {

        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();

        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $userData1 = new $this->userData();//UserData();
        $rechargeData=new $this->rechargeData();
        $tranactionData=new $this->tranactionData();
        $invitationData=new $this->invitationData();
        $rakeBackTypeData=new $this->rakeBackTypeData();
        $rebateData=new $this->rebateData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        
        /// 加入 == 
        $reportfilter =[
           "filters"=>[
           // "start"=>$startd,
           "end"=>['=',$endd],
           "user"=>['=',$userId],
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

        $resModel = $this->newitem();
        $res = array();
        $res["cyc"] = $reportType;
        
        //$rpt["no"] = DocNoMaker::Generate($this->noPre);
        $res["start"] = $startd;
        $res["end"] = $endd;
        //$rpt["accountid"] = $accountid;
        $reportAdapter->saveToModel(false, $res, $resModel);
        $this->create($resModel);
        $res = $reportAdapter->getDataContract($resModel, null, true);
        $userInfo=$userData1->get($userId);
        // dump($userInfo);
        if(empty($userInfo)) {
            return ErrorData::$USER_NOT_FOUND;
        }
        //测试结束修改回来
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);

        //前一天以及间隔数据处理
        $status=$this->getLastReport($userId, $start);
        // dump($status);
        if(empty($status)) {
            $res['initInv'] = 0;
            $res['initRecharge'] = 0;
            $res['rbInitInv']=0;
            //$res['report_tranactionsum']=0;
            $res['initBuy']=0;
            $res['rbRechargeInit']=0;
            $res['rbBuyInit']=0;


            $res['currentInv']=0;
            $res['rbCurrentInv']=0;

            $res['resultBuy']=0;
            $res['resultRecharge']=0;

            $res['rbRechargeResult']=0;
            $res['rbCurrentInv']=0;
            $res['rbBuyResult']=0;
            $res['rbBuyTotalResult']=0;

            $res['rbRechargeStart']=date("Y-m-d h:i:s");
            $res['rbBuyStart']=date("Y-m-d h:i:s");

        }
        else
        {
            $start=$status->report_end;
            $res['start']=$status->report_end;
        }
        
        //当天数据处理
        $invTodayPersonId = $invitationData->getUserInvCodeDaily($userInvcode, $start, $end);
        $sumToday=count($invTodayPersonId);
        $countToday=0;
        $tranactionCountToday=0;
        $tranactionUserCountToday=0;
        $tranactionSumToday=0;
        $tranactionSumToday=0;
        $rbRechargeToday=0;
        $rbBuyToday=0;

        // foreach($invPersonId as $id){
        //     $countToday=$countToday+$rechargeData->getRechargeCountDaily($id,$start,$end);
        //     $orderDailyToday=$tranactionData->getOrderByBuyUserIdDaily($id,$start,$end);
        //     $tranactionCountToday=$tranactionCountToday + $tranactionData->getOrderSumByBuyUserIdDaily($id,$start,$end);   
        //     $tranactionSumToday=$tranactionSumToday + count($orderDailyToday);  
        //     $getUserCount=$tranactionData->getUserCountDaily($id,$start,$end);
        //     if(!empty($getUserCount))
        //     {
        //         $tranactionUserCountToday++;
        //     }   
        // }
        
        $res['no']=DocNoMaker::Generate("RED");
        $res['name']=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";
        $res['user']=$userId;
        $res['cyc']=$reportType;

        $res['ascInv'] = $sumToday;
        $res['rbAscInv']=$sts["rbbuyascinv"];
        $res['ascRecharge'] = $sts["rbrecharge"];
        //$res['tranactionsum']=$tranactionSumToday;
        $res['ascBuy']=$sts["rbbuy"];
        $res['rbRechargeAsc']=0;//$rakeBackTypeData->getUserRechargeRakeBack($res['ascRecharge']);//计算出初始充值返佣
        $res['rbBuyAsc']=$rakeBackTypeData->getUserBuyRakeBackDirect($res['ascBuy']);//计算出初始消费返佣

        $res['rbRechargeIspay']=0;
        $res['rbBuyIspay']=0;
        //无法找到昨天记录，判断为新用户，开始生成新日报
        if(empty($status)) {
            
            /*$res['currentInv']=$sumToday;
            $res['rbCurrentInv']=$res['rbAscInv'];
            $res['resultBuy']=$tranactionCountToday;

            $res['resultRecharge']=$countToday;
            $res['rbRechargeResult']=$res['rbRechargeAsc'];
            $res['rbCurrentInv']=$res['rbAscInv'];
            $res['rbBuyResult']=$res['rbBuyAsc'];
            $res['rbBuyResult']=$res['rbBuyAsc'];*/

            $res['currentInv']=$res['ascInv'] + $res['initInv'];
            $res['resultRecharge']=$res['ascRecharge'] + $res['initRecharge'];
            $res['rbCurrentInv']=$res['rbAscInv'] + $res['rbInitInv'];
            $res['resultBuy']=floor(($res['ascBuy'] + $res['initBuy']) * 100)/100;
            $res['rbRechargeResult']=floor(($res['rbRechargeAsc'] + $res['rbRechargeInit']) * 100)/100;
            $res['rbBuyResult']=floor(($res['rbBuyAsc'] + $res['rbBuyInit']) * 100)/100; 
            $res['rbBuyTotalResult']=floor($res['rbBuyAsc'] * 100)/100;

            $res['rbRechargeStart']=date("Y-m-d h:i:s");
            $res['rbBuyStart']=date("Y-m-d h:i:s");

        }
        //已核算，已审核，重置返佣
        else if(($status->report_rbbuy_ispay==1)&&($status->report_rbbuy_chkuser!=null)) {
            
            $res['initInv'] = $status->report_currentinv;
            $res['initRecharge'] = $status->report_resultrecharge;
            $res['rbInitInv']=$status->report_rbcurrentinv;
            //$res['user_tranactionsum_yesterday']=$tranactionSumYesterday;
            $res['initBuy']=$status->report_resultbuy ;//* 100)/100;
            $res['rbRechargeInit']=0;
            $res['rbBuyInit']=0;

            $res['currentInv']=$res['ascInv'] + $res['initInv'];
            $res['resultRecharge']=$res['ascRecharge'] + $res['initRecharge'];
            $res['rbCurrentInv']=$res['rbAscInv'] + $res['rbInitInv'];
            $res['resultBuy']=floor(($res['ascBuy'] + $res['initBuy']) * 100)/100;
            $res['rbRechargeResult']=floor(($res['rbRechargeAsc'] + $res['rbRechargeInit']) * 100)/100;
            $res['rbBuyResult']=floor(($res['rbBuyAsc'] + $res['rbBuyInit']) * 100)/100; 
            $res['rbBuyTotalResult']=floor(($status->report_rbbuy_totalresult + $res['rbBuyAsc']) * 100)/100;
            $res['rbRechargeStart']=date("Y-m-d h:i:s");
            $res['rbBuyStart']=date("Y-m-d h:i:s");
            $res['start']=$status->report_end;
        }
        //已核算，未审核（或审核不通过），拒绝返佣，返佣累加（目前有问题，等待拆分）
        //未核算，未审核，返佣累加
        else
        {
            if(($status->report_rbbuy_ispay==1)&&($status->report_rbbuy_chkuser==null)) {
                $rebateData->rebateFalse($status->report_no);
            }
            $res['initInv'] = $status->report_currentinv;
            $res['initRecharge'] = $status->report_resultrecharge;
            $res['rbInitInv']=$status->report_rbcurrentinv;
            //$res['user_tranactionsum_yesterday']=$tranactionSumYesterday;
            $res['initBuy']=floor($status->report_resultbuy * 100)/100;
            $res['rbRechargeInit']=floor($status->report_rbrecharge_result * 100)/100;
            $res['rbBuyInit']=floor($status->report_rbbuy_result * 100)/100;

            $res['currentInv']=$res['ascInv'] + $res['initInv'];
            $res['resultRecharge']=$res['ascRecharge'] + $res['initRecharge'];
            $res['rbCurrentInv']=$res['rbAscInv'] + $res['rbInitInv'];
            $res['resultBuy']=floor(($res['ascBuy'] + $res['initBuy']) * 100)/100;
            $res['rbRechargeResult']=floor(($res['rbRechargeAsc'] + $res['rbRechargeInit']) * 100)/100;
            $res['rbBuyResult']=floor(($res['rbBuyAsc'] + $res['rbBuyInit'])* 100)/100;
            $res['rbBuyTotalResult']=floor(($status->report_rbbuy_totalresult + $res['rbBuyAsc']) * 100)/100;
            $res['rbRechargeStart']=date("Y-m-d h:i:s");
            $res['rbBuyStart']=date("Y-m-d h:i:s"); 
            $res['start']=$status->report_end;          
        }

        $res['enableOperation']=1;
        $rbType=$userInfo->user_currentrbtype;
        if(($rbType==null)||($rbType==0)) {
            if(empty($status)) {
                $res['rbBuyAsc']=0;
                $res['rbRechargeAsc']=0;

                $res['initInv'] = 0;
                $res['initRecharge'] = 0;
                $res['rbInitInv']=0;
                $res['initBuy']=0;
                $res['rbRechargeInit']=0;
                $res['rbBuyInit']=0;

                /*$res['currentInv']=$sumToday;
                $res['rbCurrentInv']=$res['rbAscInv'];

                $res['resultBuy']=$tranactionCountToday;
                $res['resultRecharge']=$countToday;

                $res['rbRechargeResult']=0;
                $res['rbCurrentInv']=$res['rbAscInv'];
                $res['rbBuyResult']=0;*/

                $res['currentInv']=$res['ascInv'] + $res['initInv'];
                $res['rbCurrentInv']=$res['rbAscInv'] + $res['rbInitInv'];

                $res['resultBuy']=floor(($res['ascBuy'] + $res['initBuy']) * 100)/100;
                $res['resultRecharge']=$res['ascRecharge'] + $res['initRecharge'];

                $res['rbRechargeResult']=0;
                $res['rbBuyResult']=0;
                $res['rbBuyTotalResult']=0;

                $res['rbRechargeStart']=date("Y-m-d h:i:s");
                $res['rbBuyStart']=date("Y-m-d h:i:s");
                
            }
            else
            {
                $res['rbBuyAsc']=0;
                $res['rbRechargeAsc']=0;

                $res['initInv'] = $status->report_currentinv;
                $res['initRecharge'] = $status->report_resultrecharge;
                $res['rbInitInv']=$status->report_rbcurrentinv;
                //$res['user_tranactionsum_yesterday']=$tranactionSumYesterday;
                $res['initBuy']=floor($status->report_resultbuy * 100)/100;
                $res['rbRechargeInit']=0;
                $res['rbBuyInit']=0;

                $res['currentInv']=$res['ascInv'] + $res['initInv'];
                $res['resultRecharge']=$res['ascRecharge'] + $res['initRecharge'];
                $res['rbCurrentInv']=$res['rbAscInv'] + $res['rbInitInv'];
                $res['resultBuy']=floor(($res['ascBuy'] + $res['initBuy']) * 100)/100;
                $res['rbRechargeResult']=0;
                $res['rbBuyResult']=0;
                $res['rbBuyTotalResult']=0;
                $res['rbRechargeStart']=date("Y-m-d h:i:s");
                $res['rbBuyStart']=date("Y-m-d h:i:s");  
                $res['start']=$status->report_end;         
            }
        }
        $reportAdapter->saveToModel(false, $res, $resModel);
        $this->save($resModel);
        // $lk->unlock($lockKey);

        $changeModel=$this->newitem();
        if(!empty($status) && $status->report_enable_operation!=false) {
          
            $changeModel->where('report_no', $status->report_no)->update(['report_enable_operation'=>0]);
        }
        return $res;
    }    
    
    public function makeDayReport($id,$sts,$start,$end)
    {
        $userData=new $this->userData();
            $this->createReport(
                $id,
                date_format($start, "Y-m-d 0:00:00"), $end,
                'CYC01', $sts
            );
            // $id ++;
            // }
        return 0;
    }

    public function makeDayReportById($userId)
    {
        
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
        $this->createReport($userId, $start, $end, $this::$DAY);
        return 0;
    }
}