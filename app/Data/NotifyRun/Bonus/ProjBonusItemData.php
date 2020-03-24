<?php
namespace App\Data\NotifyRun\Bonus;
use App\Data\Notify\INotifyData;
use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Notify\INotifyDefault;
use App\Data\IDataFactory;
use App\Data\Api\SMS\SmsVerify;
use App\Data\Bonus\ProjBonusItemData as BonusItemData;
use App\Data\API\SMS\SmsVerifyFactory;

class ProjBonusItemData extends IDatafactory implements INotifyDefault
{
    /**
     * 根据分红单据下的分红子表发送信息
     *
     * @param $data 数据
     */
    public function notifyrun($data)
    {
        $bonusNo = $data['bonus_no'];
        $coinType = $data['bonus_proj'];
        $authDate = $data['bonus_authdate'];
        $userId = $data['bonus_userid'];

        $where['bonus_no'] = $bonusNo;
        $where['bonus_proj'] = $coinType;
        $where['bonus_success'] = 1;
        $where['bonus_authdate'] = $authDate;
        $where['bonus_userid'] = $userId;

        $bonusItemData=new BonusItemData();
        $model = $bonusItemData->newitem();
        $bonusItem = $model->where($where)->first();
        $userData=new UserData();
        $cashAccountData=new CashAccountData();

        $userInfo=$userData->get($userId);
        if(!$userInfo->user_name) {
            $name="用户";
        }
        else
        {
            $name=$userInfo->user_name;
        }
        $phone=$userInfo->user_mobile;
        $money=round($data['bonus_cash'], 2);
        $user=round($cashAccountData->getCashToday($userId), 2);

        //通知用户
        $smsVerifyFac=new SmsVerifyFactory();
        $verify = $smsVerifyFac->CreateSms();
        $verify->SendBonusNotify($phone, $bonusNo, $name, $money, $user);
    }
}
