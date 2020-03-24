<?php
namespace App\Data\API\SMS;
use App\Data\API\SMS\ISmsVerify;
use App\Data\Sys\SendSmsData;
use iscms\AlismsSdk\TopClient;
use iscms\Alisms\SendsmsPusher;
use Illuminate\Support\Facades\Redis;
use App\Data\User\CashAccountData;
Class SmsVerify implements ISmsVerify
{

    public function RequireSms($res,$type)
    {
        return true;
    }

    /**
     * 判断验证码是否正确
     *
     * @param  $mobile 手机号
     * @param  $code 验证码
     * @author zhoutao
     * @date   2017.11.20
     */
    public function CheckSms($mobile,$code)
    {
        if (Redis::exists($mobile) && Redis::get($mobile) == $code) {
            //清空验证码
            Redis::command('del', [$mobile]);
            return true;
        }
        return false;
    }
    /**
     * 发送充值通知
     *
     * @param   $phone      手机号
     * @param   $no         单据号
     * @param   $userName   用户名
     * @param   $money      充值金额
     * @param   $user       余额
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function SendRechargeNotify($phone, $no, $userName, $money, $user)
    {
        $sendSmsData=new SendSmsData();
        $topClient=new TopClient('', '');
        $sms=new SendsmsPusher($topClient);
        $type=SendSmsData::SEND_SMS_TYPE_RECHARGE;
        $sendSmsData->sendNotify($phone, $type, $sms, $no, $userName, $money, $user);
        return true;
    }
    /**
     * 发送提现通知
     *
     * @param   $phone      手机号
     * @param   $no         单据号
     * @param   $userName   用户名
     * @param   $money      提现金额
     * @param   $user       余额
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function SendWithdrawalNotify($phone, $no, $userName, $money, $user)
    {
        $sendSmsData=new SendSmsData();
        $cashAccountData=new CashAccountData();
        $topClient=new TopClient('', '');
        $sms=new SendsmsPusher($topClient);
        $type=SendSmsData::SEND_SMS_TYPE_WITHDRAWAL;
        $sendSmsData->sendNotify($phone, $type, $sms, $no, $userName, $money, $user);
        return true;
    }

    /**
     * 发送分红通知
     *
     * @param   $phone      手机号
     * @param   $no         单据号
     * @param   $userName   用户名
     * @param   $money      分红金额
     * @param   $user       余额
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function SendBonusNotify($phone, $no, $userName, $money, $user)
    {
        $sendSmsData=new SendSmsData();
        $cashAccountData=new CashAccountData();
        $topClient=new TopClient('', '');
        $sms=new SendsmsPusher($topClient);
        $type=SendSmsData::SEND_SMS_TYPE_BONUS;
        $sendSmsData->sendNotify($phone, $type, $sms, $no, $userName, $money, $user);
        return true;
    }
}
