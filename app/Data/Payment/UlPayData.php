<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;
use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocNoMaker;
use App\Data\API\Payment\PaymentServiceFactory ;
use App\Data\User\UserData;
use App\Data\Product\PreOrderData;
use Illuminate\Support\Facades\DB;
use App\Data\User\UserTypeData;
use App\Data\Sys\ErrorData;
use App\Data\CashRecharge\CashRechargeFactory;

class UlPayData extends IDatafactory
{
    /**
     * 充值
     */
    public function cashRecharge($channelid, $amount, $date)
    {
        DB::beginTransaction();

        $docNo = new DocNoMaker();

        $channelData = new PayChannelData;
        $channel = $channelData->get($channelid);
        $desbankId = $channel->channel_withdralbankno;

        $rechargeFac = new CashRechargeFactory;
        $cashRechargeData = $rechargeFac->createData($channelid);
        $cashRechageData = new RechargeData;
        $thirdRecharge = $cashRechargeData->recharge($amount);
        $rechargeNo = array_get($thirdRecharge, 'rechargeNo');

        $serviceFac = new PaymentServiceFactory();
        $pay = $serviceFac->createService();
        $date = date('Ymd');
        $result = $pay->PreparePay($rechargeNo, $date, $amount);
        if ($result->success) {
            $cashRechageData->saveThirdNo($rechargeNo, $result->thirdplatdocno);
            DB::commit();
            return $rechargeNo;
        }
        DB::rollBack();
        $res = [];
        $res = array_add($res, "code", $result->code);
        $res = array_add($res, "msg", $result->msg);
        return $res;
    }

    /**
     * 充值确认
     */
    public function cashRechargeTrue($rechargeNo, $bankCard, $code)
    {
        DB::beginTransaction();
        $serviceFac = new PaymentServiceFactory();
        $pay = $serviceFac->createService();
        $date = date('Ymd');
        $userid = $this->session->userid;

        $userData = new UserData;
        $user = $userData->get($userid);
        $username = $user->user_name;
        $idno = $user->user_idno;
        $mobile = $user->user_mobile;

        $result = $pay->ConfirmPay($rechargeNo, $date, $userid, $bankCard, $username, $idno, $mobile, $code);

        if ($result->success) {
            $rechargeData = new RechargeData;
            $recharge = $rechargeData->getByNo($rechargeNo);
            $channelid = $recharge->cash_recharge_channel;

            $rechargeFac = new CashRechargeFactory;
            $cashRechargeData = $rechargeFac->createData($channelid);
            $cashRechargeData->rechargeTrue($rechargeNo);
            $rechargeData->saveBankCard($rechargeNo, $bankCard);
            DB::commit();
            return null;
        }
        DB::rollBack();
        $res = [];
        $res = array_add($res, "code", $result->code);
        $res = array_add($res, "msg", $result->msg);
        return $res;

    }

    /**
     * 发送短信
     */
    public function sendSms($rechargeNo, $mobile)
    {
        DB::beginTransaction();
        $serviceFac = new PaymentServiceFactory();
        $pay = $serviceFac->createService();
        $result = $pay->RequireSms($rechargeNo, $mobile);
        if ($result->success) {
            $cashRechageData = new RechargeData;
            $cashRechageData->saveMobile($rechargeNo, $mobile);
            DB::commit();
            return null;
        }
        DB::rollBack();
        $res = [];
        $res = array_add($res, "code", $result->code);
        $res = array_add($res, "msg", $result->msg);
        return $res;

    }

    /**
     * 验证用户信息
     */
    public function checkUser()
    {

    }
}
