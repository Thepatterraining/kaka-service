<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
//use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Report\ReportUserCoinItemDayData;

abstract class IReportUserCoinDayData extends IDataFactory
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
    
    protected $modelclass = 'App\Model\Report\ReportUserCoinDay';

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
        $coinAccountData=new $this->coinAccountData();
        $rabateData=new $this->rabateData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
           "filters"=>[
           "start"=>['=',$startd],
           "end"=>['=',$end],
           "user"=>$userId,
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

        //当天数据处理
        $invTodayPersonId = $invitationData->getUserInvCodeDaily($userInvcode, $start, $end);
        $sumToday=count($invTodayPersonId);

        $res['no']=DocNoMaker::GenerateReport("RUC");
        $res['name']=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日第".$userId."号用户报表";
        $res['user']=$userId;
        $res['userMobile']=$userInfo->user_mobile;
        $res['userName']=$userInfo->user_name;
        $res['cyc']=$reportType;

        $res['invUser']=$sumToday;
        $res['invCode']=$userInfo->user_invcode;

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
        $res=$this->createReport(
            $id,
            $start, $end,
            'CYC01'
        );
        $coinAccountData=new $this->coinAccountData();
        $reportUserCoinDayData=new ReportUserCoinDayData();
        $reportUserCoinItemDayData=new ReportUserCoinItemDayData();
        $item=$reportUserCoinDayData->getById($id, $res['start']);
        $tmp=$coinAccountData->getInfo($id);

        if($item != null) {            
            foreach($tmp as $value)
            {
                $reportUserCoinItemDayData->createReport($item->report_no, $value->usercoin_cointype);
            }
        }
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
