<?php
namespace App\Data\API\SMS;

interface ISmsVerify
{


    function RequireSms($res,$type);

    function CheckSms($mobile,$code); 

    function SendRechargeNotify($phone, $no, $userName, $money, $user);

    function SendWithdrawalNotify($phone, $no, $userName, $money, $user);

    function SendBonusNotify($phone, $no, $userName, $money, $user);

}
