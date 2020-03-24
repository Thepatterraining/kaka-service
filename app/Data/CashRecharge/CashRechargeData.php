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
use App\Data\Utils\DocNoMaker;
use App\Data\Payment\PayChannelData;
use App\Data\Payment\PayIncomedocsData;
use App\Data\Payment\PayData;
use App\Data\Payment\PayJournalData;
use App\Data\Payment\PayMethodsData;
use App\Data\Payment\PayChannelMethodData;
use App\Http\Adapter\Pay\PayMethodsAdapter;
use App\Data\User\UserData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\User\UserTypeData;
use App\Data\Cash\RechargeData;

/**
 * 线下现金充值
 *
 * @author zhoutao
 * @date   2017.11.22
 */
class CashRechargeData extends IDataFactory implements ICashRecharge
{
    const RECHARGE_EVENT_TYPE = 'Recharge_Check';
    const RECHARGE_BODY = 'CRB00';

    private $channelid = 0;
    private $bankCard = '';
    
    public function load_data($channelid, $bankCard)
    {
        if (empty($channelid)) {
            $userTypeData = new UserTypeData;
            $sysConfigs = $userTypeData->getData($this->session->userid);
            $channelid = $sysConfigs[UserTypeData::$CASH_RECHARGE_CHANNEL];
        }
        $this->channelid = $channelid;
        $this->bankCard = $bankCard;
    }


    /**
     * 充值操作
     *
     * @param   $amount 充值金额
     * @param   $bankCard 银行卡号
     * @param   $mobile 手机号
     * @author  zhoutao
     * @date    2017.11.21
     * @version 0.1
     */
    public function recharge($amount, $bankCard, $mobile)
    {
        $lk = new LockData();
        $key = 'recharge' . $this->session->userid;
        $lk->lock($key);
        DB::beginTransaction();

        $date = date('Y-m-d H:i:s');
        
        $cashRechageData = new RechargeData();
        $userTypeData = new UserTypeData;
        $channelData = new PayChannelData;

        //查询充值通道和银行卡
        $channelid = $this->channelid;
        $channelInfo = $channelData->get($channelid);
        $desbankId = $channelInfo->channel_withdralbankno;
        
        //写入充值表
        $bankCard = str_replace(' ', '', $bankCard);
        $rechargeNo = $cashRechageData->addRecharge($mobile, $amount, $bankCard, $desbankId, $date, RechargeData::APPLY_TYPE, $channelid);

        DB::commit();
        $lk->unlock($key);
        $res['success'] = true;
        $res['code'] = 0;
        $res['msg'] = $rechargeNo;
        return $res;
    }

    /**
     * 充值成功
     *
     * @param  $rechargeNo 充值单
     * @author zhoutao
     * @date   2017.11.21
     */
    public function rechargeTrue($rechargeNo, $code = 0)
    {
        $lk = new LockData();
        $rechargeKey = 'recharge' . $rechargeNo;
        $lk->lock($rechargeKey);
        //开始事务
        DB::beginTransaction();

        //查找充值表
        $cashRechageData = new RechargeData();
        $rechargeInfo = $cashRechageData->getRecharge($rechargeNo);
        $desbankId = $rechargeInfo->cash_recharge_desbankid;
        $amount = $rechargeInfo->cash_recharge_amount;
        $userid = $rechargeInfo->cash_recharge_userid;
        $status = $rechargeInfo->cash_recharge_status;
        $date = date('Y-m-d H:i:s');

        if ($status == RechargeData::STATUS_APPLY) {

            //资金池银行卡账户表  余额 += 充值金额
            $cashBankAccountData = new BankAccountData();
            $cashBankAccountData->saveCashduo($desbankId, $amount, $date);

            //资金池现金表 余额 += 充值金额
            $SysCashData = new CashData();
            $SysCashData->increaseCash($rechargeNo, $desbankId, $amount, JournalData::RECHARGE_TYPE, JournalData::SUCCESS_STATUS, $date);

            //用户余额表 余额增加  --余额 += 充值金额
            $userCashAccountData = new CashAccountData();
            $userCashAccountData->increaseCash($rechargeNo, $amount, CashJournalData::RECHARGE_TYPE, CashJournalData::STATUS_SUCCESS, $userid, $date);
        
            //更新充值表
            $cashRechageData->saveRecharge($rechargeNo, 1, $this->session->userid, $date);

            //写入用户现金记录
            $userCashOrderData = new CashOrderData();
            $balance = $userCashAccountData->getCashToday($userid);
            $userCashOrderData->add($rechargeNo, $amount, CashOrderData::RECHARGE_TYPE, $balance, $userid);

            //通知用户
            $this->AddEvent(self::RECHARGE_EVENT_TYPE, $userid, $rechargeNo);

            DB::commit();
            $lk->unlock($rechargeKey);
            return true;
        }
        return true;
    }

    /**
     * 充值失败
     *
     * @param  $rechargeNo 充值单
     * @author zhoutao
     * @date   2017.11.21
     */
    public function rechargeFalse($rechargeNo)
    {
        $lk = new LockData();
        $rechargeKey = 'recharge' . $rechargeNo;
        $lk->lock($rechargeKey);

        //开始事务
        DB::beginTransaction();
        //查找充值表
        $cashRechageData = new RechargeData();
        $rechargeInfo = $cashRechageData->getRecharge($rechargeNo);
        $status = $rechargeInfo->cash_recharge_status;
        $date = date('Y-m-d H:i:s');
        
        if ($status == RechargeData::STATUS_APPLY) {

            //更新充值表
            $cashRechageData->saveRecharge($rechargeNo, 0, $this->session->userid, $date, self::RECHARGE_BODY);

        }
        DB::commit();
        $lk->unlock($rechargeKey);
        return true;
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
