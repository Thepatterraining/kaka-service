<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\BankAccountData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\User\CashOrderData;
use Illuminate\Support\Facades\DB;
use App\Data\Sys\LockData;

class PayUserData extends IDatafactory
{
    protected $modelclass = 'App\Model\Sys\PayUser';

    protected $no = 'pay_no';

    const REBATE_TYPE = 'SPU01'; //返佣
    const BACK_NOW_TYPE = 'SPU02'; //返现

    const APPLY_STATUS = 'SPUT01'; //申请
    const SUCCESS_STATUS = 'SPUT02'; //成功
    const FAIL_STATUS = 'SPUT03'; //失败

    const REBATE_JOB_TYPE = 'SPUJ01'; //返佣
    const RECONCILIATION_JOB_TYPE = 'SPUJ02'; //系统平账

    const EVENT_TYPE = 'SysPayUser_Check';

    /**
     * 写入返现信息
     *
     * @param  $sysBankNo 系统卡号
     * @param  $userid 用户
     * @param  $amount 金额
     * @param  $type 类型
     * @param  $status 状态
     * @param  $jobType 关联单号类型
     * @param  $jobNo 关联单号
     * @param  $note 说明
     * @param  $payuser 发起人
     * @param  $date 发起时间
     * @author zhoutao
     */
    public function add($sysBankNo, $userid, $amount, $type, $status, $jobType, $jobNo, $note, $payuser, $date = null)
    {
        $docNo = new DocNoMaker;
        $no = $docNo->Generate('SPU');

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }

        $model = $this->newitem();
        $model->pay_no = $no;
        $model->pay_sysbankno = $sysBankNo;
        $model->pay_userid = $userid;
        $model->pay_amount = $amount;
        $model->pay_type = $type;
        $model->pay_status = $status;
        $model->pay_jobtype = $jobType;
        $model->pay_jobno = $jobNo;
        $model->pay_note = $note;
        $model->pay_payuser = $payuser;
        $model->pay_paytime = $date;
        $this->create($model);
        return $model;
    }

    /**
     * 生成返现
     *
     * @param  $sysBankNo 系统卡号
     * @param  $userid 用户
     * @param  $amount 金额
     * @param  $note 说明
     * 
     * 1 插入返现信息
     * 2 获取单号 金额 写入系统流水（平台账户）
     * 3 写入系统流水（托管账户）
     * 4 写入用户流水
     * 5 返回单号
     * 
     * 增加了银行卡
     * @author zhoutao
     * @date   2017.9.14
     */
    public function createPay($sysBankNo,$userid,$amount,$note)
    {

        DB::beginTransaction();
        $payuser = $this->session->userid;
        $date = date('Y-m-d H:i:s');
        $sysPayUser = $this->add($sysBankNo, $userid, $amount, PayUserData::BACK_NOW_TYPE, PayUserData::APPLY_STATUS, PayUserData::RECONCILIATION_JOB_TYPE, '', $note, $payuser, $date);
        $no = $sysPayUser->pay_no;

            $cash = $amount; // 金额
            $pending = $cash; //在途金额

            
            //插入系统流水 （平台账户） 可用减少 在途增加
            $cashBankData = new BankAccountData;
            $cashBankData->reduceCashIncreasePending(BankAccountData::TYPE_PLATFORM, $no, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date, $sysBankNo);
            

            //插入系统流水 （托管账户） 在途增加
            $cashBankData->increasePending(BankAccountData::TYPE_ESCROW, $no, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date, $sysBankNo);

            //写入用户流水 在途增加
            $userCashAccountData = new CashAccountData;
            $userCashAccountData->increasePending($no, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);

        DB::commit();
            return $no;
    }


    /**
     * 审核返现成功
     *
     * @param  $payNo 返现单号
     * @author zhoutao
     * 
     * 1 查询返现单信息
     * 2 取出用户 金额
     * 3 写入系统流水（平台账户）
     * 4 写入 系统流水（托管账户）
     * 5 写入 用户流水
     * 6 更新 返现单信息
     * 7 写入资金账单
     * 
     * 增加了状态判断和银行卡
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改了redis key
     * @author zhoutao
     * @date   2017.10.10
     * 
     * 增加通知用户
     * @author zhoutao
     * @date   2017.11.1
     */
    public function payTrue($payNo)
    {
        $lk = new LockData();
        $key = 'payConfirm' . $payNo;
        $lk->lock($key);
        DB::beginTransaction();
        $payInfo = $this->getByNo($payNo);
        $userid = $payInfo->pay_userid;  //用户id
        $cash = $payInfo->pay_amount; // 金额
        $pending = $cash; //在途金额
        $status = $payInfo->pay_status;
        $bankCard = $payInfo->pay_sysbankno;

        if ($status == PayUserData::APPLY_STATUS) {
            
            //插入系统流水（平台账户） 在途减少
            $date = date('Y-m-d H:i:s');
            $cashBankData = new BankAccountData;
            $cashBankData->reducePending(BankAccountData::TYPE_PLATFORM, $payNo, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date, $bankCard);


            //插入系统流水（托管账户）在途减少 可用增加
            $cashBankData->increaseCashReducePending(BankAccountData::TYPE_ESCROW, $payNo, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date, $bankCard);


            //插入用户流水 在途减少 可用增加
            $userCashAccountData = new CashAccountData;
            $userCashAccountRes = $userCashAccountData->increaseCashReducePending($payNo, $cash, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);

            //更新返现单为成功
            $this->success($payNo, $date);

            //通知用户
            $this->AddEvent(self::EVENT_TYPE, $userid, $payNo);

            //写入资金账单
            $userCashOrderData = new CashOrderData();
            $balance = $userCashAccountRes['accountCash'];
            $cashOrderRes = $userCashOrderData->add($payNo, $cash, CashOrderData::BACK_NOW_TYPE, $balance, $userid);
        }

            

        DB::commit();
        $lk->unlock($key);
        return $payInfo;
    }

    /**
     * 更新返现单为成功
     *
     * @param  $payNo 单号
     * @param  $date 时间
     * @author zhoutao
     */
    public function success($payNo,$date)
    {
        $pay = $this->getByNo($payNo);
        $pay->pay_ischeck = 1;
        $pay->pay_checkuser = $this->session->userid;
        $pay->pay_checktime = $date;
        $pay->pay_status = PayUserData::SUCCESS_STATUS;
        $this->save($pay);
    }

    /**
     * 审核 失败
     *
     * @param  $payNo 返现单号
     * @author zhoutao
     * 
     * 1 查询返现单信息
     * 2 取出用户 金额
     * 3 写入系统流水（平台账户）
     * 4 写入 系统流水（托管账户）
     * 5 写入 用户流水
     * 6 更新 返现单信息
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改了redis key
     * @author zhoutao
     * @date   2017.10.10
     */
    public function payFalse($payNo)
    {
        $lk = new LockData();
        $key = 'payConfirm' . $payNo;
        $lk->lock($key);

        DB::beginTransaction();
        $payInfo = $this->getByNo($payNo);
        $cash = $payInfo->pay_amount; //金额
        $pending = $cash;
        $userid = $payInfo->pay_userid; //用户id

        
        //插入系统流水（平台账户） 可用增加 在途减少
        $cashBankData = new BankAccountData;
        $date = date('Y-m-d H:i:s');
        $cashBankData->increaseCashReducePending(BankAccountData::TYPE_PLATFORM, $payNo, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


        //插入系统流水（托管账户）在途减少
        $cashBankData->reducePending(BankAccountData::TYPE_ESCROW, $payNo, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


        //插入用户流水 在途减少
        $userCashAccountData = new CashAccountData;
        $userCashAccountData->reducePending($payNo, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);

        //更新返现单信息为失败
        $this->fail($payNo, $date);

        DB::commit();
        $lk->unlock($key);
        return $payInfo;
    }

    /**
     * 更新返现单为失败
     *
     * @param  $payNo 单号
     * @param  $date 时间
     * @author zhoutao
     */
    public function fail($payNo,$date)
    {
        $pay = $this->getByNo($payNo);
        $pay->pay_checkuser = $this->session->userid;
        $pay->pay_checktime = $date;
        $pay->pay_status = PayUserData::FAIL_STATUS;
        $this->save($pay);
    }
}
