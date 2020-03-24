<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Report\ReportUserCoinDayData;

abstract class IReportUserCoinItemDayData extends IDataFactory
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
    
    protected $modelclass = 'App\Model\Report\ReportUserCoinItemDay';

    abstract protected function getLastReport($no,$coinType);
    
    //去掉redis锁 2017.9.5 liu
    public function createReport($no,$coinType)
    {

        $coinData=new ReportUserCoinDayData();
        $reportInfo=$coinData->getReportByNo($no);
        $userId=$reportInfo->report_user;
        $start=$reportInfo->report_start;
        $end=$reportInfo->report_end;

        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();

        $last=date_create($start);
        date_add($last, date_interval_create_from_date_string("-1 days"));
        $lastd=date_format($last, 'Y-m-d');

        $startd = date_format(date_create($start), 'Y-m-d');
        $endd = date_format(date_create($end), 'Y-m-d');
        
        $userData1 = new $this->userData();//UserData();
        $rechargeData=new $this->rechargeData();
        $tranactionData=new $this->tranactionData();
        $invitationData=new $this->invitationData();
        $rakeBackTypeData=new $this->rakeBackTypeData();
        $withdrawalData=new $this->withdrawalData();
        $voucherStorageData=new $this->voucherStorageData();
        $voucherInfoData=new $this->voucherInfoData();
        $userCashJournalData=new $this->userCashJournalData();
        $coinJournalData=new $this->coinJournalData();
        $rabateData=new $this->rabateData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
           "filters"=>[
           "no"=>['=',$no],
           "coinType"=>['=',$coinType]
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
        
        //$rpt["no"] = DocNoMaker::Generate($this->noPre);
        $res["no"] = $no;
        $res["date"]=$startd;
        $res["coinType"]=$coinType;
        //$rpt["accountid"] = $accountid;
        $reportAdapter->saveToModel(false, $res, $resModel);
        $this->create($resModel);
        
        $res = $reportAdapter->getDataContract($resModel, null, true);

        $userInfo=$userData1->get($userId);
        if(empty($userInfo)) {
            return ErrorData::$USER_NOT_FOUND;
        }

        //前一天以及间隔数据处理
        $status=$this->getLastReport($userId, $coinType);//更改report！
        //无法找到昨天记录，判断为新用户，开始生成新日报
        if(empty($status)) {
            $res['initCount']=0;
            $res['initPending']=0;
        }
        
        else
        {
            $res['initCount'] = $status->report_count;
            $res['initPending'] = $status->report_pending;
            $res['start']=$status->report_end;     
            $start=$status->report_end;          
        }

        //测试结束修改回来
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);

        //前一天以及间隔数据处理
        $status=$this->getLastReport($userId, $coinType);//更改report！
        //无法找到昨天记录，判断为新用户，开始生成新日报
        if(empty($status)) {
            $res['initCount']=0;
            $res['initPending']=0;
        }
        
        else
        {
            $res['initCount'] = $status->report_count;
            $res['initPending'] = $status->report_pending;  
            // $res['start']=$status->report_end;
            // $start=$status->report_end;    
        }

        $res['buy']=$coinJournalData->getBuyCoinToday($userId, $coinType, $start, $end);
        $res['sell']=$coinJournalData->getSellCoinToday($userId, $coinType, $start, $end);
        $res['frozen']=$coinJournalData->getFrozenCoinToday($userId, $coinType, $start, $end);

        // $res['count']=$coinJournalData->getCashToday($userId,$coinType,$start,$end);
        // dump($res['count']);
        // $res['pending']=$coinJournalData->getPendingToday($userId,$coinType,$start,$end);

        //当天数据处理
        $invTodayPersonId = $invitationData->getUserInvCodeDaily($userInvcode, $start, $end);
        $sumToday=count($invTodayPersonId);

        $res['recharge']=0;
        $res['withdrawal']=0;

        //$res['invUser']=$sumToday;
        //$res['invCode']=$userInfo->user_invcode;

        $res['start']=$start;
        $res['end']=$end;

        $res['count']=$coinJournalData->getCashToday($userId, $coinType, $end);
        $res['pending']=$coinJournalData->getPendingToday($userId, $coinType, $end);
        $res['holding']=$res['count']+$res['pending'];

        $reportAdapter->saveToModel(false, $res, $resModel);
        //dump($resModel);
        $this->save($resModel);
        // $lk->unlock($lockKey);
        return $res;
    }    
    
    public function makeDayReport($id)
    {
        
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
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
