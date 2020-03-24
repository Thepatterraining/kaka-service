<?php
namespace App\Data\CashRecharge;

use App\Data\Cash\BankAccountData;
use App\Data\IDataFactory;
use App\Data\User\CashOrderData;
use Illuminate\Support\Facades\DB;
use App\Data\Cash\JournalData;
use App\Data\Sys\CashData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Sys\LockData;
use App\Data\Payment\PayChannelData;
use App\Data\Payment\PayData;
use App\Data\Payment\PayMethodsData;
use App\Data\Payment\PayChannelMethodData;
use App\Http\Adapter\Pay\PayMethodsAdapter;
use App\Data\User\UserData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\User\UserTypeData;
use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;

/**
 * 第三方现金充值
 *
 * @author zhoutao
 * @date   2017.11.22
 */
class ThirdRechargeData extends IDataFactory implements ICashRecharge
{
    const RECHARGE_EVENT_TYPE = 'Recharge_Check';

    private $channelid = 0;
    private $bankCard = '';
    
    public function load_data($channelid, $bankCard)
    {
        $this->channelid = $channelid;
        $this->bankCard = $bankCard;
    }

     /**
      * 第三方冲值申请
      *
      * @param   $bankCard 银行卡号 默认空
      * @param   $amount 充值金额
      * @param   $mobile 手机号 默认空
      * @author  zhoutao
      * @version 0.1
      * @date    2017.11.22
      */
    public function recharge($amount, $bankCard = '', $mobile = '')
    {
        $lockData = new LockData;
        $userid = $this->session->userid;
        $key = 'recharge' . $userid;
        $lockData->lock($key);

        DB::beginTransaction();

        $userRechargeData = new UserRechargeData;
        $thirdRecharge = $userRechargeData->thirdRecharge($amount, $this->channelid);

        
        if ($thirdRecharge['success']) {
            DB::commit();
        } else {
            DB::rollBack();
        }
        $lockData->unlock($key);
        return $thirdRecharge;
    }


    /**
     * 第三方冲值确认
     *
     * @param   $rechargeNo 充值单据号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.22
     */
    public function rechargeTrue($rechargeNo, $code = 0)
    {
        $lockData = new LockData;
        $key = 'recharge' . $rechargeNo;
        $lockData->lock($key);

        DB::beginTransaction();
        
        $userRechargeData = new UserRechargeData;
        $thirdRecharge = $userRechargeData->thirdRechargeTrue($rechargeNo);
        
        if ($thirdRecharge['success']) {
            DB::commit();
        } else {
            DB::rollBack();
        }
        $lockData->unlock($key);
        return $thirdRecharge;
    }


     /**
      * 第三方冲值失败
      *
      * @param   $rechargeNo 充值单据号
      * @author  zhoutao
      * @version 0.1
      * @date    2017.11.22
      */
    public function rechargeFalse($rechargeNo)
    {
        $lockData = new LockData;
        $key = 'recharge' . $rechargeNo;
        $lockData->lock($key);

        $rechargeData = new RechargeData();
        //查询充值信息
        $rechargeInfo = $rechargeData->getByNo($rechargeNo);
        $amount = $rechargeInfo->cash_recharge_amount;
        $userid = $rechargeInfo->cash_recharge_userid;
        $status = $rechargeInfo->cash_recharge_status;
        $channelid = $rechargeInfo->cash_recharge_channel;
        $type  =  $rechargeInfo -> cash_recharge_type;

        if ($status == RechargeData::STATUS_APPLY && $type === RechargeData::THIRDPAYMENT_TYPE) {
            $date = date('Y-m-d H:i:s');

            //查询通道
            $channelData = new PayChannelData();
            $channelInfo = $channelData->get($channelid);
            $payplatformid = $channelInfo->channel_payplatform; //pay id
            $infeeRate = $channelInfo->channel_infeerate; //入账手续费率
            $infeeType = $channelInfo->channel_infeetype; //入帐手续费类型
            $withBankNo = $channelInfo->channel_withdralbankno; //提现账号

            //查询平台
            $payData = new PayData();
            $payInfo = $payData->get($payplatformid);
            $sysBankid = $payInfo->pay_withdrawalbankno; //系统银行账号
            $provisionsBankid = $payInfo->pay_provisions; //备付金账号
            $trusteeshipBankid = $payInfo->pay_trusteeship; //托管账户
            $payAccessid = $payInfo->pay_accessid;  //id
            $payAccesskey = $payInfo->pay_accesskey; //key

            DB::beginTransaction();

            //写入用户资金 在途减少
            $userCashAccountData = new CashAccountData;
            
            $balance = $userCashAccountData->reducePending($rechargeNo, $amount, $userid, CashJournalData::TYPE_Third_RECHARGE, CashJournalData::STATUS_FAULT, $date);

            //写入平台托管账户
            $bankAccountData = new BankAccountData();

            $bankAccountData->reducePending(BankAccountData::TYPE_ESCROW, $rechargeNo, $amount, SysCashJournalData::TYPE_Third_RECHARGE, SysCashJournalData::STATUS_FAULT, $date, $trusteeshipBankid);

            //写入平台备付金账户
            $bankAccountData->increaseCashReducePending(BankAccountData::TYPE_STOCK_FUND, $rechargeNo, $amount, $amount, SysCashJournalData::TYPE_Third_RECHARGE, SysCashJournalData::STATUS_FAULT, $date, $provisionsBankid);

            //更新充值表
            $rechargeData->saveRecharge($rechargeNo, 0, 0, $date);

            DB::commit();
        }

        $lockData->unlock($key);
        return $rechargeNo;
    }

    /**
     * 发送短信
     *
     * @param  $rechargeNo 充值单
     * @param  $mobile 手机号
     * @author zhoutao
     * @date   2017.11.23
     */
    public function sendSms($rechargeNo, $mobile)
    {
        return true;
    }
}
