<?php
namespace App\Data\API\SMS;

use App\Data\API\SMS\ISmsVerify;

/** 
 * 短信接口测试类
 *
 * @author  liu
 * @date    Auth 25th,2017
 * @version 1.0
 **/

class TestVerify implements ISmsVerify
{
    function RequireSms($mobile,$type)
    {
        return true;
    }
    
    function CheckSms($mobile,$code)
    {
        return true;
    }

    function SendRechargeNotify($phone, $no, $userName, $money, $user)
    {
        return true;
    }

    function SendWithdrawalNotify($phone, $no, $userName, $money, $user)
    {
        return true;
    }

    public function SendBonusNotify($phone, $no, $userName, $money, $user)
    {
        return true;
    }
}