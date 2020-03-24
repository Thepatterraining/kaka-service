<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Schedule\ScheduleItemData;
use App\Data\Activity\InvitationData;
use App\Data\Notify\INotifyData;
use App\Data\Sys\LogData;
use App\Data\Sys\UserData;
use App\Data\Monitor\DebugInfoData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Report\ReportTradeDayData;
use App\Data\Report\ReportUserCashDayData;
use App\Data\Report\ReportRechargeDayData;
use App\Data\Report\ReportSumsDayData;
use App\Data\Report\ReportWithdrawalDayData;
use App\Data\Settlement\UserCashSettlementData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Report\ReportSettlementDayListData;
use App\Data\Report\ReportSettlementMonthListData;
use App\Data\Payment\PayData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Report\ReportUserrbSubDayInfoData;
use App\Observers\ModelObserver;
use App\Data\Cash\RechargeData;
use App\Data\Auth\MakeConfigEvent;
use App\Observers\QueueTestObserver;
use App\Model\Cash\Recharge;
use App\Data\MessageQueue\RabbitMQ;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Notify\NotifyGroupSetData;
use App\Observers\TransactionOrderObserver;
use App\Observers\TransactionSellObserver;
use App\Observers\TransactionBuyObserver;  
use App\Common\BoolExpression\BoolExpFactory;
// use App\Common\BoolExpression\ExpFactory;
use App\Data\Common\LeftExpFactory;
use App\Data\Common\RightExpFactory;
use App\Data\File\UploadData;
use App\Data\Settlement\UserCoinSettlementData;
use App\Data\Bonus\ProjBonusPlanTypeData;
use App\Data\Resource\ResourceBannerpicData;
use App\Observers\LendingDocInfoObserver;
use App\Data\Lending\LendingDocInfoData;
use App\Http\Utils\Queue;
use App\Http\Utils\RaiseEvent;
use App\Data\Bonus\ProjBonusData;
use App\Data\NotifyRun\Sys\LogData as NotifyLogData;

use MongoDB;
use SplStack;
// use Mongo;

class DataBasicTest extends TestCase
{
 

    use Queue,RaiseEvent;

    public function testExample()
    {

        $reportCoinDayData=new ReportUserCoinDayData();
        $reportTradeDayData=new ReportTradeDayData();
        // $reportCashDayData=new ReportUserCashDayData();
        $reportWithdrawalDayData=new ReportWithdrawalDayData();
        $reportUserSumsDayData=new ReportSumsDayData();
        $reportCashDayData=new ReportUserCashDayData();
        $reportRechargeDayData=new ReportRechargeDayData();
        $userCashSettlementData=new UserCashSettlementData();
        $reportUserrbSubDayData=new ReportUserrbSubDayData();
        $notifyData=new INotifyData();
        $reportSettlementDayListData=new ReportSettlementDayListData();
        $reportSettlementMonthListData=new ReportSettlementMonthListData();
        $payData=new PayData();
        $rakebackTypeData=new RakebackTypeData();
        $userRechargeData=new UserRechargeData();
        $reportUserrbSubDayInfoData=new ReportUserrbSubDayInfoData();
        $rechargeData=new RechargeData();
        $userData=new UserData();
        $queueTestObserver=new QueueTestObserver();
        $transactionOrderObserver=new TransactionOrderObserver();
        $transactionSellObserver=new TransactionSellObserver();
        $transactionBuyObserver=new TransactionBuyObserver();
        $tranactionSellData=new TranactionSellData();
        $tranactionBuyData=new TranactionBuyData();
        $tranactionOrderData=new TranactionOrderData();
        $notifyGroupSetData=new NotifyGroupSetData();
        $leftFactory=new LeftExpFactory(1);
        $rightFactory=new RightExpFactory();
        $userCoinSettlementData=new UserCoinSettlementData();
        $logData=new LogData();
        $projectBonusPlanTypeData=new ProjBonusPlanTypeData();
        $resourceBannerpicData=new ResourceBannerpicData();
        $boolExpreFactory=new BoolExpFactory($leftFactory, $rightFactory, "reg_time>='2017-4-6'||cash_availble<=1");
        // $expFactory=new ExpFactory();
        $uploadData=new UploadData();
        $lendingDocInfoObserver=new LendingDocInfoObserver();
        $lendingDocInfoData=new LendingDocInfoData();
        $projBonusData=new ProjBonusData();
        $notifyLogData=new NotifyLogData();

        $tmp=array();
        $tmp[0]="fj0pvxqm";
        $tmp[1]="icra5dkw";
        $start=date_create(date("2017-4-6"));

        $end=date_create(date("2017-4-7"));
        $date=date("2017-4-6");
        $defineId=1;
        $groupId=2;
        // $date=date_create($start);
        $diviendTime=mktime(0, 0, 0, 1, $defineId+1, 2017);
        dump($diviendTime);
        // $data=[
        //     'cash_recharge_userid'=>3026,
        //     'cash_recharge_phone'=>'18645679959',
        //     'cash_recharge_no'=>'CR2017102620024313918',
        //     'created_at'=>'2017-10-25 19:45:28',
        //     'cash_recharge_useramount'=>'2000',
        //     'dumpinfo'=>"time to set server",
        //     'lending_status'=>'LDS04',
        //     'queueKey'=>'saved'
        // ];
        $data= 
        [ 'id'=> 38,
          'bonus_no'=> 'CBN2017112215572924604',
          'bonus_proj'=> 'KKC-BJ0006',
          'bonus_authdate'=> '2017-11-22 00:00:00',
          'bonus_plancash'=> 1.14,
          'bonus_planfee'=> 0,
          'bonus_dealcash'=> 2.28,
          'bonus_dealfee'=> -1.14,
          'bonus_cash'=> 1.14,
          'bonus_unit'=> 0.01,
          'bonus_holdings'=> 2,
          'bonus_distributecount'=> 2,
          'bonus_status'=> 'PBS02',
          'bonus_chkuserid'=> 0,
          'bonus_chktime'=> '2017-11-22 15:57:29',
          'bonus_time'=> '2017-11-22 15:57:29',
          'created_at'=> '2017-11-22 15:57:29',
          'updated_at'=> '2017-11-22 15:57:29',
          'deleted_at'=> null,
          'created_id'=> 0,
           'updated_id'=> null,
           'deleted_id'=> null,
           'bonus_rightno'=> '',
           'bonus_starttime'=> '2017-11-15 00:00:00',
           'bonus_endtime'=> '2017-11-25 00:00:00',
           'bonus_instalment'=> '第8期',
           'queueKey'=> 'saved',
            'dumpinfo'=>'' ];
        //    $projBonusData->notifysaveddefaultrun($data);

        // $this->CallbackQueueHandle($data, config("rabbitmq.jsexname"), 'sys_message'); 
        // $this->RaisQueueEvent();
        // $logData->notifyemailrun(/*"liusimeng@kakamf.com"*/$data['queueKey'],"刘思萌",null,$data);
        // dump($projectBonusPlanTypeData->JudgePlanType(1,'2017-10-1','2017-10-3'));
        // $lendingDocInfoObserver->saved($data->save());
        // $data->save();
        $name="主页轮播图";
        $modelDefineId=1;
        $modelDefineDataId=1;
        $resModelDefineId=1;
        $resourceModelDataId=1;
        $model=$tranactionOrderData->newitem()->where('id', 7)->first();
        $transactionOrderObserver->created($model);
        $this->RaisQueueEvent();
        // $model=$logData->newitem()->where('id',538)->first();
        // // dump($model);
        // $array["dumpinfo"]=$model->dumpinfo;
        // $array["created_at"]=$model->created_at;
        // dump($array);
        // $notifyLogData->notifyrun($array);
        // $res=$resourceBannerpicData->changeBannerpic(3,4,1,$modelDefineId,$modelDefineDataId,$resModelDefineId,$resourceModelDataId,null,$name,1,null);
        // dump($resourceBannerpicData->getBanner($name));
        // $rechargeData->notifysaveddefaultrun($data);
        // $reportSettlementMonthListData->run();
        // $start=date_format($start,'Y-W');
        // dump($start);
        // $exp="reg_time>='2017-4-6'||cash_availble<=1";
        // $data=$tranactionOrderData->newitem()->orderBy('id','desc')->first();
        

        // $reportTradeDayData->run();
        // dump($boolExpreFactory->Handle());
        // DB::beginTransaction();
        // $notifyGroupSetData->addNotifyGroupSet($defineId,$groupId);
        // DB::insert("insert into event_notifygroupset (id,notify_defineid,notify_groupid,
        //             created_at,updated_at,deleted_at,created_id,updated_id,deleted_id) values (?,?,?,?,?,?,?,?,?)",[10,2,3,null,null,null,null,null,null]);
        // DB::rollBack();
        // $reportSettlementDayListData->run();
        // for($i=1;$i<6;$i++)
        // {
        //     $data=$tranactionOrderData->newitem()->where('id',$i)->orderBy('id','desc')->first();
        //     $transactionOrderObserver->created($data);
        // }

        // $a=date("Y-m-d h:i:s");
        // $b=date("Y-m-d 0:00:00");
        // $b=date_create($b);
        // $b=date_format($b,"Y-m-d 0:00:00");
        // $b=date_create($b);
        // $b=date_format($b,"Y-m-d 0:00:00");
        // var_dump($b);
        // $c=strtotime($b)-strtotime($a);
        // var_dump($c);
        return true;
    }
}
