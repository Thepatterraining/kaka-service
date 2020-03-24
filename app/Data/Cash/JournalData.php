<?php
namespace App\Data\Cash;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\CashData;

class JournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $no = 'cash_journal_no';

    protected $modelclass = 'App\Model\Cash\Journal';

    public static $JOURNALNO_PREFIX = 'CCJ';

    const WITHDRAWAL_TYPE = 'CJ01';
    const RECHARGE_TYPE = 'CJ02';
    const VOUCHER_TYPE = 'CJ03';
    const CASH_JOURNALDOC_TYPE = 'CJ04';

    const APPLY_STATUS = 'CJT01';
    const SUCCESS_STATUS = 'CJT02';
    const FAIL_STATUS = 'CJT03';
    const OFFSET_STATUS = 'CJT05';
    const VOUCHER_STATUS = 'CJT07';
    const CASH_JOURNALDOC_STATUS = 'CJT12';

    /**
     * 增加现金流水表在途金额
     *
     * @param   $SysCashModel 系统余额表数据
     * @param   $journaNo  流水表单据号
     * @param   $amount  充值金额
     * @param   $rechargeNo  关联单据号
     * @param   $desbankId  充值银行卡号
     * @author  zhoutao
     * @version 0.1
     */
    public function addCashPending($SysCashModel, $journaNo, $amount, $rechargeNo, $desbankId, $type = 'CJ02', $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_journal_no = $journaNo;
        $model->cash_journal_datetime = $date;
        $model->cash_journal_pending = $amount;
        $model->cash_result_pending = $SysCashModel['pending'];
        $model->cash_result_cash = $SysCashModel['cash'];
        $model->cash_journal_type = $type;
        $model->cash_journal_jobno = $rechargeNo;
        $model->cash_journal_status = 'CJT01';
        $model->cash_account_id = $desbankId;
        return $docMd5->AddHash($model);
    }

    /**
     * 充值成功，增加流水表收入，减少在途
     *
     * @param   $SysCashModel 系统数据
     * @param   $journaNo 流水单据号
     * @param   $amount 金额
     * @param   $rechargeNo 充值单据号
     * @param   $desbankId 卡号
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function trueAddCashPending($SysCashModel, $journaNo, $amount, $rechargeNo, $desbankId, $status)
    {
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_journal_no = $journaNo;
        $model->cash_journal_datetime = date('Y-m-d H:i:s');
        $model->cash_journal_in = $amount;
        $model->cash_journal_pending = -$amount;
        $model->cash_result_pending = $SysCashModel['pending'];
        $model->cash_result_cash = $SysCashModel['cash'];
        $model->cash_journal_type = 'CJ02';
        $model->cash_journal_jobno = $rechargeNo;
        $model->cash_journal_status = $status;
        $model->cash_account_id = $desbankId;
        return $docMd5->AddHash($model);
    }

    /**
     * 充值成功，增加流水表收入
     *
     * @param   $SysCashModel 系统数据
     * @param   $journaNo 流水单据号
     * @param   $amount 金额
     * @param   $rechargeNo 充值单据号
     * @param   $desbankId 卡号
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function trueAddCashPendingTwo($SysCashModel, $journaNo, $amount, $rechargeNo, $desbankId, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_journal_no = $journaNo;
        $model->cash_journal_datetime = $date;
        $model->cash_journal_in = $amount;
        $model->cash_result_pending = $SysCashModel['pending'];
        $model->cash_result_cash = $SysCashModel['cash'];
        $model->cash_journal_type = 'CJ02';
        $model->cash_journal_jobno = $rechargeNo;
        $model->cash_journal_status = $status;
        $model->cash_account_id = $desbankId;
        return $docMd5->AddHash($model);
    }

    /**
     * 充值失败，减少在途
     *
     * @param   $SysCashModel 系统数据
     * @param   $journaNo 流水单据号
     * @param   $amount 金额
     * @param   $rechargeNo 充值单据号
     * @param   $desbankId 卡号
     * @param   $status 状态
     * @author  zhoutao
     * @version 0.1
     */
    public function falseAddCashPending($SysCashModel, $journaNo, $amount, $rechargeNo, $desbankId, $status, $type = 'CJ02', $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_journal_no = $journaNo;
        $model->cash_journal_datetime = $date;
        $model->cash_journal_pending = -$amount;
        $model->cash_result_pending = $SysCashModel['pending'];
        $model->cash_result_cash = $SysCashModel['cash'];
        $model->cash_journal_type = $type;
        $model->cash_journal_jobno = $rechargeNo;
        $model->cash_journal_status = $status;
        $model->cash_account_id = $desbankId;
        return $docMd5->AddHash($model);
    }

    /**
     * 平台流水 平掉在途 支出提现金额 - 手续费
     *
     * @param  $journaNo 流水单据号
     * @param  $toBankId 银行卡号
     * @param  $withdrawalNo 提现单据号
     * @param  $SysCashModel 系统model
     * @param  $pending 在途金额
     * @param  $out 支出金额
     * @return bool
     */
    public function addOutPending($journaNo, $toBankId, $withdrawalNo, $SysCashModel, $pending, $out, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_journal_no = $journaNo;
        $model->cash_journal_datetime = $date;
        $model->cash_journal_pending = $pending;
        $model->cash_result_pending = $SysCashModel['pending'];
        $model->cash_result_cash = $SysCashModel['cash'];
        $model->cash_journal_out = $out;
        $model->cash_journal_type = 'CJ01';
        $model->cash_journal_jobno = $withdrawalNo;
        $model->cash_journal_status = 'CJT02';
        $model->cash_account_id = $toBankId;
        return $docMd5->AddHash($model);
    }

    /**
     * 第三方充值  托管账户
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeEscrow($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        if ($bankType == BankAccountData::TYPE_STOCK_FUND) {
            $cashAccount = $cashBankAccountData->saveTypePendingCash($sysBankid, $amount, $amount, $bankType, $date);
        } else if ($bankType == BankAccountData::TYPE_ESCROW) {
            $cashAccount = $cashBankAccountData->saveTypePending($sysBankid, $amount, $bankType, $date);
        }

        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, $amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }


    /**
     * 第三方充值确认
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeTrue($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        if ($bankType == BankAccountData::TYPE_STOCK_FUND) {
            $cashAccount = $cashBankAccountData->saveTypePendingLess($sysBankid, $amount, $bankType, $date);
        } else if ($bankType ==BankAccountData::TYPE_ESCROW) {
            $cashAccount = $cashBankAccountData->saveTypeCashPending($sysBankid, $amount, $amount, $bankType, $date);
        }

        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, $amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }

    /**
     * 第三方充值入账
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeIncomedocs($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date)
    {
        //增加平台托管账户
        $cashData = new CashData();
        
        $cashAccount = $cashData->saveTypePending($amount, $date);

        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, $amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }

    /**
     * 第三方充值入账
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeIncomedocsTrue($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date)
    {
        //增加平台托管账户
        $cashData = new CashData();
        
        $cashAccount = $cashData->saveTypeCashPending($amount, $date);

        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, -$amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }

    /**
     * 第三方充值入账
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeIncomedocsFalse($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date)
    {
        //增加平台托管账户
        $cashData = new CashData();
        
        $cashAccount = $cashData->savePendingReduce($amount, $date);

        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, -$amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }

    /**
     * 第三方充值
     *
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 银行卡号
     * @param   $amount 金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdPartyRechargeStockFund($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();
        $cashAccount = $cashBankAccountData->saveTypePendingCash($sysBankid, $amount, $amount, BankAccountData::TYPE_STOCK_FUND, $date);
        //写入流水
        $journalNo = $this->add($jobNo, $sysBankid, $cashAccount, $amount, $type, $status, $in, $out, $date);
        return $journalNo;
    }

    /**
     * 增加流水
     *
     * @param   $journaNo 流水单据号
     * @param   $jobNo 关联单据号
     * @param   $sysBankid 卡号
     * @param   $cashAccount
     * @param   $pending 在途金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   $in 收入
     * @param   $out 支出
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function add($jobNo, $sysBankid, $cashAccount, $pending, $type, $status, $in = 0, $out = 0, $date = null)
    {
        $docNo = new DocNoMaker();
        $journalNo = $docNo->Generate($this::$JOURNALNO_PREFIX);
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->cash_account_id = $sysBankid;
        $model->cash_journal_no = $journalNo;
        $model->cash_journal_datetime = $date;
        $model->cash_journal_pending = $pending;
        $model->cash_journal_in = $in;
        $model->cash_journal_out = $out;
        $model->cash_result_pending = $cashAccount['accountPending'];
        $model->cash_result_cash = $cashAccount['accountCash'];
        $model->cash_journal_type = $type;
        $model->cash_journal_jobno = $jobNo;
        $model->cash_journal_status = $status;
        $docMd5->AddHash($model);
        return $journalNo;
    }
}
