<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportUserCashDayData;

abstract class IReportUserCashDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected $tranactionData="";
    protected $invitationData="";
    protected $rakeBackTypeData="";
    protected $rabateData="";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportUserCashDay';

    abstract protected function getLastReport($userId);
    
    //去掉redis锁 2017.9.5 liu
    public function createReport($userId,$start,$end,$reportType)
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
        $withdrawalData=new $this->withdrawalData();
        $voucherStorageData=new $this->voucherStorageData();
        $voucherInfoData=new $this->voucherInfoData();
        $userCashJournalData=new $this->userCashJournalData();
        $rabateData=new $this->rabateData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
           "filters"=>[
           "start"=>['=',$startd],
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
        if(empty($userInfo)) {
            return ErrorData::$USER_NOT_FOUND;
        }
        //测试结束修改回来
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);

        //前一天以及间隔数据处理
        $status=$this->getLastReport($userId);
        // dump($status);
        //无法找到昨天记录，判断为新用户，开始生成新日报
        if(empty($status)) {
            $res['initCash']=0;
            $res['initPending']=0;
        }
        
        else
        {
            $res['initCash'] = $status->report_resultcash;
            $res['initPending'] = $status->report_resultpending;    
            $res['start']=$status->report_end; 
            // dump($res['start']);
            $start=$status->report_end;
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

        $rechargeCashToday=$rechargeData->getRechargeTrueCountDaily($userId, $start, $end);
        $rechargeCountToday=$rechargeData->getRechargeAmountDetailDaily($userId, $start, $end);
        $rechargeFeeToday=0;//$rechargeData->getRechargeFeeDaily($userId,$start,$end);

        $drawalCashToday=0;
        $drawalFeeToday=0;
        $drawalDailyToday=$withdrawalData->getUserWithCash($userId, 'CW01', $start, $end);
        if(!empty($drawDailyToday)) {
            foreach($drawalDailyToday as $drawalvalue){
                $drawalCashToday=$drawalCashToday + $drawalvalue->cash_withdrawal_amount;
                $drawalFeeToday=$drawalFeeToday + $drawalvalue->cash_withdrawal_fee;
            }
            $drawalCountToday=count($drawalDailyToday);
        }
        else{
            $drawalCountToday=0;
        }

        $buyCashToday=0;
        $buyFeeToday=0;
        $orderBuyDailyToday=$tranactionData->getOrderByBuyUserIdDaily($userId, $start, $end);
        if(!empty($orderBuyDailyToday)) {
            foreach($orderBuyDailyToday as $buyvalue){
                $buyCashToday=$buyCashToday + $buyvalue->order_amount;
                $buyFeeToday=$buyFeeToday + $buyvalue->order_buycash_fee;
            }
            $buyCountToday=count($orderBuyDailyToday);
        }
        else{
            $buyCountToday=0;     
        }

        $sellCashToday=0;
        $sellFeeToday=0;
        $orderSellDailyToday=$tranactionData->getOrderBySellUserIdDaily($userId, $start, $end);
        if(!empty($orderBuyDailyToday)) {
            foreach($orderSellDailyToday as $sellvalue){
                $sellCashToday=$sellCashToday + $sellvalue->order_amount;
                $sellFeeToday=$sellFeeToday + $sellvalue->order_sellcash_fee;
            }
            $sellCountToday=count($orderSellDailyToday);
        }
        else{
            $sellCountToday=0;     
        }

        $voucherCashToday=0;
        $voucherStorageToday=$voucherStorageData->getVoucherDaily($userId, $start, $end);
        if(!empty($voucherStorageToday)) {
            foreach($voucherStorageToday as $vouchervalue){
                $tmp=$vouchervalue->vaucherstorage_voucherno;
                $tmpInfo=$voucherInfoData->getByNo($tmp);
                if(!empty($tmpInfo)) {
                    $voucherCashToday=$voucherCashToday + intval($tmpInfo->voucher_val2);
                }
            }
            $voucherCountToday=count($voucherStorageToday);
        }
        else{
            $voucherCountToday=0;     
        }

        $voucherUnuseCash=0;
        $voucherUnuse=$voucherStorageData->getUnuseVoucher($userId);
        if(!empty($voucherUnuse)) {
            foreach($voucherUnuse as $unusevalue){
                $tmp=$unusevalue->vaucherstorage_voucherno;
                $tmpInfo=$voucherInfoData->getByNo($tmp);
                $voucherUnuseCash=$voucherUnuseCash + intval($tmpInfo->voucher_val2);
            }
            $voucherUnuseCount=count($voucherUnuse);
        }
        else{
            $voucherUnuseCountToday=0;     
        }

        //$voucherStorageToday=$voucherStorageData->getVoucherDaily($userId,$start,$end);

        $userCashToday=$userCashJournalData->getCashToday($userId, $start, $end);
        $userPendingToday=$userCashJournalData->getPendingToday($userId, $start, $end);

        $income=$rechargeCashToday+$sellCashToday-$sellFeeToday;
        $outcome=$drawalCountToday+$rechargeFeeToday+$drawalFeeToday+$sellFeeToday+$buyCashToday;

        $res['no']=DocNoMaker::Generate("RUC");
        $res['name']=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日第".$userId."号用户报表";
        $res['user']=$userId;
        $res['userMobile']=$userInfo->user_mobile;
        $res['userName']=$userInfo->user_name;
        $res['cyc']=$reportType;

        $res['invUser']=$sumToday;
        $res['invCode']=$userInfo->user_invcode;

        $res['rechargeCash'] = $rechargeCashToday;
        $res['rechargeCount'] = $rechargeCountToday;

        $res['withDrawalCash']=$drawalCashToday;
        $res['withDrawalCount']=$drawalCountToday;
        
        $res['buyCount']=$buyCountToday;
        $res['buyCash']=$buyCashToday;

        $res['sellCount']=$sellCountToday;
        $res['sellCash']=$sellCashToday;

        $res['cashFee']=$rechargeFeeToday+$drawalFeeToday;
        $res['trade']=$sellFeeToday+$buyFeeToday;

        $res['voucherUseCount']=$voucherCountToday;
        $res['voucherUseCash']=$voucherCashToday;

        $res['voucherCount']=$voucherUnuseCount;
        $res['voucherCash']=$voucherUnuseCash;

        $res['resultCash']=$userCashToday;
        $res['resultPending']=$userPendingToday;

        $res['otherIncome']=0;
        $res['otherOutcome']=0;

        $res['income']=$income;
        $res['outcome']=$outcome;

        // $res['start']=$start;
        $res['end']=$end;

        $reportAdapter->saveToModel(false, $res, $resModel);
        $this->save($resModel);
        // $lk->unlock($lockKey);
        return $res;
    }    
    
    public function makeDayReport($id,$start,$end)
    {
        
        // $end = date("Y-m-d 00:00:00");
        // $start = date_create($end);
        // date_add($start, date_interval_create_from_date_string("-1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');
        $userData=new $this->userData();
        // $max= $userData->getMaxId($start);
        // $id=1;
        // while($id<=$max){
        //    dump('deal  '.$id);
            $this->createReport(
                $id,
                $start, $end,
                //date_format($start,"Y-m-d H:00:00"),
                //date_format($end,"Y-m-d H:00:00"),
                'CYC01'
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
