<?php
namespace App\Data\CashRecharge;

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
use App\Data\Payment\PayChannelData;
use App\Data\Sys\LockData;

class UlPayRechargeData extends IDatafactory implements ICashRecharge
{
    private $channelid = 0;
    private $bankCard = '';
    
    public function load_data($channelid, $bankCard)
    {
        $this->channelid = $channelid;
        $this->bankCard = $bankCard;
    }

    /**
     * 充值
     *
     * @param  $amount 金额
     * @param  $bankCard 卡号
     * @param  $mobile 手机号
     * @author zhoutao
     * @date   2017.11.23
     */
    public function recharge($amount, $bankCard = '', $mobile = '')
    {
        $lockData = new LockData;
        $userid = $this->session->userid;
        $key = 'recharge' . $userid;
        $lockData->lock($key);

        DB::beginTransaction();

        $channelid = $this->channelid;
        $channelData = new PayChannelData;
        $channel = $channelData->get($channelid);
        $desbankId = $channel->channel_withdralbankno;

        $userRechargeData = new UserRechargeData;
        $cashRechageData = new RechargeData;
        $thirdRecharge = $userRechargeData->thirdRecharge($amount, $channelid);
        if ($thirdRecharge['success'] === false) {
            return $thirdRecharge;
        }
        $rechargeNo = array_get($thirdRecharge, 'msg.rechargeNo');

        $serviceFac = new PaymentServiceFactory();
        $pay = $serviceFac->createService();
        $date = date('Ymd');
        $result = $pay->PreparePay($rechargeNo, $date, $amount);
        if ($result->success) {
            $cashRechageData->saveThirdNo($rechargeNo, $result->thirdplatdocno);
            DB::commit();
            $lockData->unlock($key);
            return $rechargeNo;
        }
        DB::rollBack();
        $res = [];
        $res = array_add($res, "code", $result->code);
        $res = array_add($res, "msg", $result->msg);
        $res = array_add($res, "success", false);
        $lockData->unlock($key);
        return $res;
    }

    /**
     * 充值确认
     *
     * @param  $rechargeNo 充值单号
     * @param  $code 验证码
     * @author zhoutao
     * @date   2017.11.23
     */
    public function rechargeTrue($rechargeNo, $code)
    {
        $lockData = new LockData;
        $key = 'recharge' . $rechargeNo;
        $lockData->lock($key);

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
        $bankCard = $this->bankCard;

        $result = $pay->ConfirmPay($rechargeNo, $date, $userid, $bankCard, $username, $idno, $mobile, $code);

        if ($result->success) {
            $rechargeData = new RechargeData;
            $recharge = $rechargeData->getByNo($rechargeNo);
            $channelid = $recharge->cash_recharge_channel;

            $userRechargeData = new UserRechargeData;
            $thirdRecharge = $userRechargeData->thirdRechargeTrue($rechargeNo);
            if ($thirdRecharge['success'] === false) {
                return $thirdRecharge;
            }
            $rechargeData->saveBankCard($rechargeNo, $bankCard);
            DB::commit();
            $lockData->unlock($key);
            return null;
        }
        DB::rollBack();
        $res = [];
        $res = array_add($res, "code", $result->code);
        $res = array_add($res, "msg", $result->msg);
        $res = array_add($res, "success", false);
        $lockData->unlock($key);
        return $res;

    }

    public function rechargeFalse($rechargeNo) 
    {

    }

    /**
     * 发送短信
     *
     * @param  $rechargeNo 充值单号
     * @param  $mobile 手机号
     * @author zhoutao
     * @date   2017.11.23
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

}
