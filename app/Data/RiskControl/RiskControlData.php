<?php
namespace App\Data\RiskControl;
use App\Data\Cash\RechargeData;
use App\Data\Cash\WithdrawalData;
use App\Data\User\UserData;
use App\Data\User\CoinAccountData;
use App\Data\Item\InfoData;
use App\Data\IDataFactory;

class RiskControlData extends IDataFactory
{
    // protected $modelclass = 'App\Model\Notify\NotifyGroupSet'; 
    protected $modelclass ='';
    /**
     * 获取用户信息
     *
     * @param   $userid 用户id
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getInfo($userid)
    {
        if($userid==null) {
            $userid=$this->session->userid;
        }

        $rechargeData=new RechargeData();
        $withDrawalData=new WithDrawalData();
        $userData=new UserData();
        $coinAccountData=new CoinAccountdata();
        $infoData=new InfoData();

        $rechrgeModel=$rechargeData->newitem();
        $withDrawalModel=$withDrawalData->newitem();
        $userModel=$userData->newitem();
        $coinAccountModel=$coinAccountData->newitem();
        $infoModel=$infoData->newitem();
        //获取充值次数与总数
        $res["rechargeCount"]=$rechargeModel->where('cash_recharge_userid', $userid)->where('cash_recharge_success', 1)->count();
        $res["rechargeAmount"]=$rechargeModel->where('cash_recharge_userid', $userid)->where('cash_recharge_success', 1)->sum('cash_recharge_useramount');
        //获取提现次数与总数
        $res["withDrawalCount"]=$withDrawalModel->where('cash_recharge_userid', $userid)->where('cash_withdrawal_status', 'CW01')->count();
        $res["withDrawalAmount"]=$withDrawalModel->where('cash_recharge_userid', $userid)->where('cash_withdrawal_status', 'CW01')->sum('cash_withdrawal_amount');
        //获取上次登陆时间
        $res["lastLogin"]=$userModel->where('id', $userid)->first()->user_lastlogin;
        //获取资产总估值
        $res["totalMoney"]=0;
        $coinInfo=$coinAccountModel->where('account_userid', $userid)->get();
        if(!$coinInfo->isEmpty()) {
            foreach($coinInfo as $info)
            {
                $accout=$info->usercoin_cash + $info->usercoin_pending;
                $type=$info->usercoin_type;
                $price=$infoModel->where('coin_type', $type)->first()->price;
                $res["totalMoney"]+=$account * $price;
            }
        }
        return $res;
    }
}