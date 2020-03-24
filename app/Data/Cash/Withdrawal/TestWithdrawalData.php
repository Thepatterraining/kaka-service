<?php
namespace App\Data\Cash\Withdrawal;

use App\Data\IDataFactory;
use App\Data\User\CashOrderData;
use Illuminate\Support\Facades\DB;
use App\Data\Sys\CashData;
use App\Data\Sys\CashFeeData;
use App\Data\User\CashAccountData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\User\CashJournalData as userCashJournalData;
use App\Data\Sys\CashJournalData;
use App\Data\Cash\BankAccountData;
use App\Data\Cash\RechargeData;
use App\Data\Cash\JournalData;
use App\Data\User\UserTypeData;
use App\Data\Utils\Formater;
use App\Data\User\UserData;
use App\Data\Sys\ErrorData;
use App\Data\Cash\FinanceBankData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\CheckBankCard;
use App\Data\Cash\WithdrawalData;

class TestWithdrawalData extends IDatafactory
{
    const STATUS_APPLY = 'CW00';
    const STATUS_SUCCESS = 'CW01';
    const STATUS_FAIL = 'CW02';

    const WITHDRAWAL_APPLY_EVENT_TYPE = 'Withdrawal_Apply';
    const WITHDRAWAL_SUCCESS_EVENT_TYPE = 'Withdrawal_Check';

    const WITHDRAWAL_BODY = 'CWB00';

    private $res = [
        'code' => 0,
        'msg' => '',
        'success' => true,
    ];

    //用户提现次数
    private $withdrawalNumber = 0;

    /**
     * 判断用户金额是否足够
     *
     * @param  $amount 提现金额
     * @author zhoutao 
     * @date   2017.11.27
     */
    private function checkUserAmount($amount)
    {
        $userCashAccountData = new CashAccountData();
        $userAmount = $userCashAccountData->getCash();
        if (bccomp(strval($amount), strval($userAmount), 3) == 1 || $amount <= 0) {
            $this->res['code'] = ErrorData::$AMOUNT_ENOUGH;
            $this->res['success'] = false;
        }
    }

    /**
     * 判断是否满足最小提现金额
     *
     * @param  $amount 提现金额
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkMinAmount($amount)
    {
        if ($amount < 100) {
            $this->res['code'] = ErrorData::$WITH_AMOUNT_MIN_ONE_HUNDRED;
            $this->res['success'] = false;
        }
    }

    /**
     * 判断银行卡是否正确
     *
     * @param  $bankCard 银行卡号
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkBankCard($bankCard)
    {
        $checkBankCard = new CheckBankCard;
        return $checkBankCard->check($bankCard);
    }

    /**
     * 判断提现次数
     *
     * @param  $date 提现时间
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkWith($date)
    {
        $userData = new UserData();
        $userWith = $userData->getWith();
        $this->withdrawalNumber = $userWith['with'];
        if ($this->withdrawalNumber >= 2 && $userWith['date'] > $date) {
            $this->res['code'] = ErrorData::$WITH_MAX_FREQUENCY;
            $this->res['success'] = false;
            return $this->res;
        }
        if ($this->withdrawalNumber <= 2 && $userWith['date'] <= $date) {
            //修改提现次数 = 0
            $userData->saveUserWith(0);
            $this->withdrawalNumber = 0;
        }
    }

    /**
     * 查询系统银行卡号
     *
     * @author zhoutao
     * @date   2017.11.27
     */
    private function getSysBankCard()
    {
        $cashBankAccountData = new BankAccountData();
        $cashBankWhere['account_type'] = BankAccountData::TYPE_PLATFORM;
        $cashBankInfo = $cashBankAccountData->find($cashBankWhere);
        return $cashBankInfo->account_no;
    }

    /**
     * 判断提现金额是两位小数
     *
     * @param  $amount 提现金额
     * @author zhoutao
     * @date   2017.11.27
     */
    private function checkDecimalAmount($amount)
    {
        if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $amount)) {
            $this->res['code'] = ErrorData::$AMOUNT_TWO_DECIMAL;
            $this->res['success'] = false;
        }
    }

    /** 
     * 发起提现
     *
     * @param   $amou 提现金额
     * @param   $userBankCard 用户银行卡
     * @param   $bankNo 银行号
     * @param   $name 用户姓名
     * @param   $branchName 支行
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawal($amount, $userBankCard, $bankNo, $name, $branchName)
    {
        $lk = new LockData();
        $userid = $this->session->userid;
        $withKey = 'withdrawal' . $userid;
        $lk->lock($withKey);
        $date = date('Y-m-d H:i:s');
        $userBankCard = str_replace(' ', '', $userBankCard);
        
        //判断余额是否足够
        $this->checkUserAmount($amount);
        if ($this->res['success'] === false) {
            $lk->unlock($withKey);
            return $this->res;
        }
        
        $this->checkMinAmount($amount);
        if ($this->res['success'] === false) {
            $lk->unlock($withKey);
            return $this->res;
        }

        $this->checkDecimalAmount($amount);
        if ($this->res['success'] === false) {
            $lk->unlock($withKey);
            return $this->res;
        }

        $checkBankCard = $this->checkBankCard($userBankCard);
        if ($checkBankCard['success'] === false) {
            $lk->unlock($withKey);
            return $checkBankCard;
        }

        $this->checkWith($date);
        if ($this->res['success'] === false) {
            $lk->unlock($withKey);
            return $this->res;
        }
        
        //计算手续费
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($userid);
        $withdrawalRate = $sysConfigs[UserTypeData::$CASH_WITHDRAWAL_FEE_RATE];
        $fee = $withdrawalRate * $amount;
        $fee = Formater::ceil($fee);
        $withAmount = $amount - $fee;
        //查询系统银行卡号
        $sysBankId = $this->getSysBankCard();

        DB::beginTransaction();
        //添加银行卡
        $FinanceBankData = new FinanceBankData();
        $FinanceBankData->addBankCard($userBankCard, $name, $branchName, null, $bankNo);      

        //提现表添加数据
        $cashWithdrawalData = new WithdrawalData();
        $withdrawalNo = $cashWithdrawalData->add($amount, $userBankCard, $sysBankId, $fee, $withdrawalRate, $date);

        //平台提现手续费表增加数据  金额 = 手续费
        $sysCashFeeData = new CashFeeData();
        $sysCashFeeData->add($withdrawalNo, $withdrawalRate, $fee, $date);

        //用户 在途金额 += 提现金额 - 手续费，余额 -= 提现金额 - 手续费
        $userCashAccountData = new CashAccountData();
        $userCashAccountData->reduceCashIncreasePending($withdrawalNo, $withAmount, $withAmount, $userid, userCashJournalData::WITHDRAWAL_TYPE, userCashJournalData::STATUS_APPLY, $date);
        //用户 在途金额 += 手续费，余额 -= 手续费
        $userCashAccountData->reduceCashIncreasePending($withdrawalNo, $fee, $fee, $userid, userCashJournalData::WITHDRAWAL_FEE_TYPE, userCashJournalData::STATUS_APPLY, $date);

        //平台账户在途金额增加 -- 在途 += 手续费
        $sysCashAccountData = new SysCashAccountData();
        $sysCashAccountData->increasePending($withdrawalNo, $fee, CashJournalData::WITHDRAWAL_FEE_TYPE, CashJournalData::STATUS_APPLY, $date);

        //资金池银行卡账户表在途金额增加 -- 在途金额 += 提现金额 - 手续费
        $cashBankAccountData = new BankAccountData();
        $cashBankAccountData->saveCash($sysBankId, $withAmount, $date);
        //资金池表  --在途金额 += 提现金额 - 手续费
        $SysCashData = new CashData();
        $SysCashData->increasePending($withdrawalNo, $sysBankId, $withAmount, JournalData::WITHDRAWAL_TYPE, JournalData::APPLY_STATUS, $date);

        //修改提现次数 += 1
        $userData = new UserData();
        $userWithRes = $userData->saveUserWith($this->withdrawalNumber + 1);
        
        DB::commit();
        $lk->unlock($withKey);
        //通知用户
        $this->AddEvent(self::WITHDRAWAL_APPLY_EVENT_TYPE, $this->session->userid, $withdrawalNo);
        return $this->res;
    }
    
    /** 
     * 提现审核成功
     *
     * @param   $withdrawalNo 提现单号
     * @param   $desBank 提现卡号
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawalTrue($withdrawalNo, $desbank)
    {
        $lk = new LockData();
        $withKey = 'withdrawal' . $withdrawalNo;
        $lk->lock($withKey);
        $date = date('Y-m-d H:i:s');

        //开始事务
        DB::beginTransaction();
        //查找提现表
        $cashWithdrawalData = new WithdrawalData();
        $withInfo = $cashWithdrawalData->getByNo($withdrawalNo);
        $amount = $withInfo->cash_withdrawal_amount;
        $desbankid = $withInfo->cash_withdrawal_srcbankid;
        $userid = $withInfo->cash_withdrawal_userid;
        $fee = $withInfo->cash_withdrawal_fee;
        $cashBankAmount = $amount - $fee;
        $status = $withInfo->cash_withdrawal_status;

        //判断状态
        if ($status != self::STATUS_APPLY) {
            $this->res['code'] = ErrorData::NOT_FOUND_NO;
            $this->res['success'] = false;
            return $this->res;
        }

        //用户余额表  --在途平掉 减去提现金额
        $userCashAccountData = new CashAccountData();
        $userCashAccountData->reducePending($withdrawalNo, $cashBankAmount, $userid, userCashJournalData::WITHDRAWAL_TYPE, userCashJournalData::STATUS_SUCCESS, $date);

        //用户流水表添加数据 -- 在途平掉 = -提现手续费
        $userCashAccountData->reducePending($withdrawalNo, $fee, $userid, userCashJournalData::WITHDRAWAL_TYPE, userCashJournalData::STATUS_SUCCESS, $date);

        //平台账户在途金额增加 -- 在途平掉 = -手续费 余额 += 手续费
        $sysCashAccountData = new SysCashAccountData();
        $sysCashAccountData->increaseCashReducePending($withdrawalNo, $fee, CashJournalData::WITHDRAWAL_FEE_TYPE, CashJournalData::STATUS_SUCCESS, $date);

        //更新平台提现手续费状态为成功
        $sysCashFeeData = new CashFeeData();
        $sysCashFeeData->saveStatus($withdrawalNo, CashFeeData::SUCCESS_STATUS, 1, $date);

        //资金池表在途金额增加 -- 在途平掉 -= 提现金额 - 手续费 余额 -= 提现金额 - 手续费
        $SysCashData = new CashData();
        $sysCashRes = $SysCashData->savePendingCash($cashBankAmount, $date);

        if ($desbank == $desbankid || $desbank == null) {
            //资金池银行卡账户表在途金额增加 -- 在途平掉 -= 提现金额 - 手续费 余额 -= 提现金额 - 手续费
            $cashBankAccountData = new BankAccountData();
            $cashBankRes = $cashBankAccountData->savePendingCash($desbankid, $cashBankAmount, $date);

            //资金池流水表添加数据 -- 在途平掉 -= 提现金额 - 手续费 支出金额 = 提现金额 - 手续费
            $cashJournalData = new JournalData();
            $cashJournalData->add($withdrawalNo, $desbankid, $sysCashRes, -$cashBankAmount, JournalData::WITHDRAWAL_TYPE, JournalData::SUCCESS_STATUS, 0, $cashBankAmount, $date);
            
        } else {
            //资金池银行卡账户表在途金额增加 -- 在途平掉 -= 提现金额 - 手续
            $cashBankAccountData = new BankAccountData();
            $cashBankAmount = $amount - $fee;
            $cashBankRes = $cashBankAccountData->savePending($desbankid, $cashBankAmount, $date);


            //资金池银行卡账户表在途金额增加 -- 余额 -= 提现金额 - 手续费
            $cashBankAccountData = new BankAccountData();
            $cashBankAmount = $amount - $fee;
            $cashBankRes = $cashBankAccountData->saveCashShao($desbank, $cashBankAmount, $date);


            //资金池流水表添加数据 -- 在途平掉 -= 提现金额 - 手续费
            $cashJournalData = new JournalData();
            $cashJournalData->add($withdrawalNo, $desbankid, $sysCashRes, -$cashBankAmount, JournalData::WITHDRAWAL_TYPE, JournalData::OFFSET_STATUS, 0, 0, $date);

            //资金池流水表添加数据 -- 在途金额 = 提现金额 - 手续费
            $cashJournalData->add($withdrawalNo, $desbank, $sysCashRes, $cashBankAmount, JournalData::WITHDRAWAL_TYPE, JournalData::APPLY_STATUS, 0, 0, $date);
            
            //资金池流水表添加数据 -- 在途平掉 -= 提现金额 - 手续费 支出金额 = 提现金额 - 手续费
            $cashJournalData->add($withdrawalNo, $desbank, $sysCashRes, -$cashBankAmount, JournalData::WITHDRAWAL_TYPE, JournalData::OFFSET_STATUS, 0, 0, $date);

        }

        //更新提现表
        $cashWithdrawalData->successWith($withdrawalNo);

        //写入用户现金记录
        $userCashOrderData = new CashOrderData();
        $balance = $userCashAccountData->getCashToday($userid);
        //提现金额 - 手续费
        $userCashOrderData->add($withdrawalNo, $amount, CashOrderData::WITHDRAWAL_TYPE, $balance, $userid);

        DB::commit();
        //通知用户
        $this->AddEvent(self::WITHDRAWAL_SUCCESS_EVENT_TYPE, $userid, $withdrawalNo);

        return $this->res;
    }

    /** 
     * 提现审核拒绝
     *
     * @param   $withdrawalNo 提现单号
     * @param   $body 描述
     * @author  zhoutao
     * @date    2017.11.27
     * @version 1.0
     **/
    public function withdrawalFalse($withdrawalNo, $desbank = '')
    {
        $lk = new LockData();
        $withKey = 'withdrawalConfirm';
        $lk->lock($withKey);
        $date = date('Y-m-d H:i:s');

        //开始事务
        DB::beginTransaction();
        //查找提现表
        $cashWithdrawalData = new WithdrawalData();
        $withInfo = $cashWithdrawalData->getByNo($withdrawalNo);
        $amount = $withInfo->cash_withdrawal_amount;
        $desbankid = $withInfo->cash_withdrawal_srcbankid;
        $userid = $withInfo->cash_withdrawal_userid;
        $fee = $withInfo->cash_withdrawal_fee;
        $status = $withInfo->cash_withdrawal_status;
        $cashBankAmount = $amount - $fee;

        //判断状态
        if ($status != self::STATUS_APPLY) {
            $this->res['code'] = ErrorData::NOT_FOUND_NO;
            $this->res['success'] = false;
            return $this->res;
        }

        //用户余额表  --在途平掉 减去提现金额  余额增加 += 提现金额 - 手续费
        $userCashAccountData = new CashAccountData();
        $userCashAccountData->increaseCashReducePending($withdrawalNo, $cashBankAmount, $cashBankAmount, $userid, userCashJournalData::WITHDRAWAL_TYPE, userCashJournalData::STATUS_FAULT, $date);
        //手续费
        $userCashAccountData->increaseCashReducePending($withdrawalNo, $fee, $fee, $userid, userCashJournalData::WITHDRAWAL_FEE_TYPE, userCashJournalData::STATUS_FAULT, $date);

        //系统账户 -- 在途平掉 = -手续费
        $sysCashAccountData = new SysCashAccountData();
        $sysCashAccountData->reducePending($withdrawalNo, $fee, CashJournalData::WITHDRAWAL_FEE_TYPE, CashJournalData::STATUS_FAULT, $date);

        //资金池表在途金额增加 -- 在途平掉 -= 提现金额 - 手续费
        $SysCashData = new CashData();
        $SysCashData->reducePending($withdrawalNo, $desbankid, $cashBankAmount, JournalData::WITHDRAWAL_TYPE, JournalData::FAIL_STATUS, $date);
        //资金池银行卡账户表 -- 在途平掉 -= 提现金额 - 手续费 余额不变
        $cashBankAccountData = new BankAccountData();
        $cashBankAccountData->savePending($desbankid, $cashBankAmount, $date);

        //更新平台提现手续费状态为失败
        $sysCashFeeData = new CashFeeData();
        $sysCashFeeData->saveStatus($withdrawalNo, CashFeeData::FAIL_STATUS, false, $date);

        //更新提现表
        $cashWithdrawalData->failWith($withdrawalNo, self::WITHDRAWAL_BODY);

        DB::commit();
        return $this->res;

    }
}
