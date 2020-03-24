<?php
namespace App\Data\NotifyRun\Cash;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\Sys\CashData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as userCashJournalData;
use App\Data\Sys\CashJournalData;
use App\Data\Cash\BankAccountData;
use App\Data\Cash\RechargeData;
use App\Data\Cash\JournalData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\SendSmsData;
use iscms\AlismsSdk\TopClient;
use iscms\Alisms\SendsmsPusher;
use App\Data\User\UserData;
use App\Data\Notify\INotifyDefault;
use App\Data\API\SMS\SmsVerifyFactory;

class WithdrawalData extends IDatafactory implements INotifyDefault
{
    public function notifyrun($data)
    {
        $smsVerifyFac=new SmsVerifyFactory();
        $sendSmsData=new SendSmsData();
        $userData=new UserData();
        $cashAccountData=new CashAccountData();

        $userId=$data['cash_withdrawal_userid'];
        $userInfo=$userData->get($userId);
        if(!$userInfo->user_name) {
            $name="用户";
        }
        else
        {
            $name=$userInfo->user_name;
        }
        $phone=$userInfo->user_mobile;
        $money=round($data['cash_withdrawal_amount'], 2);
        $user=round($cashAccountData->getCashToday($userId), 2);
        $no=$data["cash_withdrawal_no"];

        $verify = $smsVerifyFac->CreateSms();
        $verify->SendWithdrawalNotify($phone, $no, $name, $money, $user);
        return true;
    }
}