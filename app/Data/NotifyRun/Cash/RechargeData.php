<?php
namespace App\Data\NotifyRun\Cash;
use App\Data\Notify\INotifyDefault;
use App\Data\IDataFactory;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use App\Data\API\SMS\SmsVerifyFactory;
class RechargeData extends IDatafactory implements INotifyDefault
{
        
    public function notifyrun($data)
    {
	info("recharge status:".$data["cash_recharge_success"]);	
	if($data["cash_recharge_success"] == true){
        $sendSmsData=new SendSmsData();
        $userData=new UserData();
        $cashAccountData=new CashAccountData();
        $userId=$data['cash_recharge_userid'];
        $phone=$data['cash_recharge_phone'];
        $userInfo=$userData->get($userId);
        if(!$userInfo->user_name) {
            $name="用户";
        }
        else
        {
            $name=$userInfo->user_name;
        }
        $money=round($data['cash_recharge_amount'], 2);
        $user=round($cashAccountData->getCashToday($userId), 2);
        $no=$data["cash_recharge_no"];

        $smsVerifyFac=new SmsVerifyFactory();
        $verify = $smsVerifyFac->CreateSms();
        $verify->SendRechargeNotify($phone, $no, $name, $money, $user);
        return true;
	}
    }
}
