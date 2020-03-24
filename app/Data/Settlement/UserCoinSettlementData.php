<?php
namespace App\Data\Settlement;

use App\Data\Settlement\ICoinSettlementData;

use App\Data\Sys\CoinData;
use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use App\Data\Sys\CoinAccountData as SysCoinAccountData;
use App\Data\Utils\Formater;
use App\Mail\CoinErrorReport;
use App\Mail\CashErrorReport;
use App\Data\Notify\INotifyData;
use Illuminate\Support\Facades\Mail;

use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;

/**
 * 用户代币对帐
 *
 * @param   $startd 开始时间
 * @param   $endd   结束时间
 * @return  mixed
 * @author  liu
 * @version 0.1
 * @date    2017.10.10
 *
 * @fix 添加比较规约 liu 2017.10.11
 */
class UserCoinSettlementData implements IDaySchedule,IHourSchedule
{

    protected function caculateJobs($startd,$endd)
    {

        //校验代币
        $coinAccountData = new CoinAccountData();
        $coinData=new CoinData();
        $userData=new UserData();
        $sysCoinAccountData=new SysCoinAccountData();
        
        $res=array();
        // $address=["geyunfei@kakamf.com","zhoutao@kakamf.com","liusimeng@kakamf.com"];
        $tmp=0;
        $ccAddress=["xuyang@kakamf.com","haojinyi@kakamf.com"];
        $model=$coinAccountData->newitem();
        $userModel=$userData->newitem();
        $sysCoinModel=$sysCoinAccountData->newitem();

        $coinInfo=$coinData->newitem()->get();
        foreach($coinInfo as $info)
        {
            $coinAccount=0;
            $type=$info->syscoin_account_type;
            $coinAccountInfo=$sysCoinModel->where('account_type', $type)->first();
            $coinCount=bcadd($coinAccountInfo->account_cash, $coinAccountInfo->account_pending, 9);
            $account=bcadd($info->syscoin_account_cash, $info->syscoin_account_pending, 9);
            $userCoinInfo=$model->where('usercoin_cointype', $type)->get();
            if(!$userCoinInfo->isEmpty()) {
                foreach($userCoinInfo as $userCoin)
                {
                    $id=$userCoin->usercoin_account_userid;
                    $cash=$userCoin->usercoin_cash;
                    $pending=$userCoin->usercoin_pending;
                    if($pending<0) {
                        $userInfo=$userModel->where('id', $id)->first();
                        $name=$userInfo->user_name;
                        $mobile=$userInfo->user_mobile;
                        $res[$tmp]["error"]="代币在途为负";
                        $res[$tmp]["userid"]=$id;
                        $res[$tmp]["username"]=$name;
                        $res[$tmp]["mobile"]=$mobile;
                        $res[$tmp]["type"]=$type;
                        $res[$tmp]["pending"]=$pending;
                        $tmp++;
                    }
                    $coinAccount=bcadd($coinAccount, bcadd($cash, $pending, 9), 9);
                }
                $coinAccount=bcadd($coinAccount, $coinCount, 9);
                if(bccomp($coinAccount, $account, 9)!=0) {
                    $res[$tmp]["error"]="发行代币总数出现偏差";
                    $res[$tmp]["type"]=$type;
                    $res[$tmp]["coinaccount"]=$coinAccount;
                    $res[$tmp]["account"]=$account;
                    $tmp++;
                }
            }
            else
            {
                if(bccomp(0, $account, 9)!=0) {
                    $res[$tmp]["error"]="发行代币总数出现偏差";
                    $res[$tmp]["type"]=$type;
                    $res[$tmp]["coinaccount"]=$coinAccount;
                    $res[$tmp]["account"]=$account;
                    $tmp++;
                }
            }
        }
        if($res) {
            $notifyData=new INotifyData();
            $event=INotifyData::COINERRORCHECK;
            $notifyData->doJob($event, $res, null, $startd);
        }

        //检查现金
        $res=array();
        $tmp=0;
        $cashAccountData=new CashAccountData();
        $cashInfo=$cashAccountData->newitem()->get();
        foreach($cashInfo as $cinfo)
        {
            $cash=$cinfo->account_cash;
            $pending=$cinfo->account_pending;
            $id=$cinfo->account_userid;
            if($pending<0) {
                $userInfo=$userModel->where('id', $id)->first();
                $name=$userInfo->user_name;
                $mobile=$userInfo->user_mobile;
                $res[$tmp]["error"]="现金在途为负";
                $res[$tmp]["userid"]=$id;
                $res[$tmp]["username"]=$name;
                $res[$tmp]["mobile"]=$mobile;
                $res[$tmp]["cash"]=$cash;
                $res[$tmp]["pending"]=$pending;
                $tmp++;
            }
        }
        if($res) {
            $notifyData=new INotifyData();
            $event=INotifyData::CASHERRORCHECK;
            $notifyData->doJob($event, $res, null, $startd);
        }
        return true;
    }

    public function makeAllUserHourSettlement()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeHourSettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    public function makeAllUserDaySettlement()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDaySettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }
    public function makeAllUserSettlement($start,$end)
    {


  
        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
           
                $this->makeSettlement($start, $end, $resultitem->id, $this::$USER);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    public function run()
    {

        $$date=date("Y-m-d 0:00:00");
        $startd=date_create($date);
        $endd=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $this->caculateJobs($startd, $endd);
        return true;
    }

    public function hourrun()
    {

        $date=date("Y-m-d H:00:00");
        $startd=date_create($date);
        $endd=date_create($date);
        date_add($startd, date_interval_create_from_date_string("-1 hour"));
        $this->caculateJobs($startd, $endd);
        return true;
    }
}
