<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\BankAccountData;

class CashJournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\CashJournal';

    protected $no = 'syscash_journal_no';

    const WITHDRAWAL_FEE_TYPE = 'SCJ01';
    const COUPONS_TYPE = 'SCJ02';
    const TYPE_Third_RECHARGE = 'SCJ04';
    const VOUCHER_TYPE = 'SCJ05';
    const REBATE_TYPE = 'SCJ08';
    const BONUS_TYPE = 'SCJ09';
    const SYS_CASH_JOURNAL_DOC_TYPE = 'SCJ10';
    const CASH_JOURNAL_DOC_TYPE = 'SCJ11';

    const STATUS_APPLY = 'CJT01';
    const STATUS_SUCCESS = 'CJT02';
    const STATUS_FAULT = 'CJT03';
    const COUPONS_STATUS = 'CJT06';
    const VOUCHER_STATUS = 'CJT08';
    const REBATE_STATUS = 'CJT09';
    const BONUS_STATUS = 'CJT10';
    const SYS_CASH_JOURNAL_DOC_STATUS = 'CJT11';
    const CASH_JOURNAL_DOC_STATUS = 'CJT12';



    /**
     * 增加提现手续费
     *
     * @param   $sysCashJournalNo 流水单据号
     * @param   $withdrawalNo 提现单据号
     * @param   $amount 手续费金额
     * @param   $sysCashAccountModel 系统现金账户信息
     * @param   string                                       $status 状态
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addWithCash($sysCashJournalNo, $withdrawalNo, $amount, $sysCashAccountModel, $status = 'CJT01', $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $sysCashJournalNo = $docNo->Generate('SCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->syscash_journal_no = $sysCashJournalNo;
        $model->syscash_journal_datetime = $date;
        $model->syscash_journal_pending = $amount;
        $model->syscash_result_pending = $sysCashAccountModel['accountPending'];
        $model->syscash_result_cash = $sysCashAccountModel['accountCash'];
        $model->syscash_journal_type = 'SCJ01';
        $model->syscash_journal_jobno = $withdrawalNo;
        $model->syscash_journal_status = $status;
        return $docMd5->AddHash($model);
    }


    /**
     * 收到手续费
     *
     * @param   $sysCashJournalNo 流水单据号
     * @param   $withdrawalNo 提现单据号
     * @param   $amount 手续费
     * @param   $sysCashAccountModel 系统账户信息
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addWithTrue($sysCashJournalNo, $withdrawalNo, $amount, $sysCashAccountModel, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $sysCashJournalNo = $docNo->Generate('SCJ');
        $docMd5 = new DocMD5Maker();
        $sysCashJournalModel = $this->newitem();
        $sysCashJournalModel->syscash_journal_no = $sysCashJournalNo;
        $sysCashJournalModel->syscash_journal_datetime = $date;
        $sysCashJournalModel->syscash_journal_pending = -$amount;
        $sysCashJournalModel->syscash_result_pending = $sysCashAccountModel['accountPending'];
        $sysCashJournalModel->syscash_result_cash = $sysCashAccountModel['accountCash'];
        $sysCashJournalModel->syscash_journal_in = $amount;
        $sysCashJournalModel->syscash_journal_type = 'SCJ01';
        $sysCashJournalModel->syscash_journal_jobno = $withdrawalNo;
        $sysCashJournalModel->syscash_journal_status = 'CJT02';
        return $docMd5->AddHash($sysCashJournalModel);
    }

    /**
     * 添加平台现金流水
     *
     * @param   $sysCashJournalNo 流水单据号
     * @param   $withdrawalNo 关联单据号
     * @param   $pending 在途
     * @param   $sysCashAccountModel 平台现金账户信息
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                                          $in   收入
     * @param   int                                          $out  支出
     * @param   null                                         $date 日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function add($sysCashJournalNo, $withdrawalNo, $pending, $sysCashAccountModel, $type, $status, $in = 0, $out = 0, $date = null, $sysBankid)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $sysCashJournalNo = $docNo->Generate('SCJ');
        $docMd5 = new DocMD5Maker();
        $sysCashJournalModel = $this->newitem();
        $sysCashJournalModel->syscash_journal_no = $sysCashJournalNo;
        $sysCashJournalModel->syscash_journal_datetime = $date;
        $sysCashJournalModel->syscash_journal_pending = $pending;
        $sysCashJournalModel->syscash_journal_in = $in;
        $sysCashJournalModel->syscash_journal_out = $out;
        $sysCashJournalModel->syscash_result_pending = $sysCashAccountModel['accountPending'];
        $sysCashJournalModel->syscash_result_cash = $sysCashAccountModel['accountCash'];
        $sysCashJournalModel->syscash_journal_type = $type;
        $sysCashJournalModel->syscash_journal_jobno = $withdrawalNo;
        $sysCashJournalModel->syscash_journal_status = $status;
        $sysCashJournalModel->syscash_jounal_account = $sysBankid;
        return $docMd5->AddHash($sysCashJournalModel);
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
        } else if ($bankType ==BankAccountData::TYPE_ESCROW) {
            $cashAccount = $cashBankAccountData->saveTypePending($sysBankid, $amount, $bankType, $date);
        }

        //写入流水
        $journalNo = $this->add('', $jobNo, $amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
        return $journalNo;
    }

    /**
     * 第三方充值入账审核  托管账户收入
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
    public function IncomedocsInEscrow($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        $cashAccount = $cashBankAccountData->saveTypeCashPending($sysBankid, $in, $amount, $bankType, $date);

        //写入流水
        $journalNo = $this->add('', $jobNo, -$amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
        return $journalNo;
    }

    /**
     * 第三方充值入账审核  备付金收入
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
    public function IncomedocsIn($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        $cashAccount = $cashBankAccountData->inCash($sysBankid, $bankType, $in, $date);

        //写入流水
        $journalNo = $this->add('', $jobNo, -$amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
        return $journalNo;
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
    public function IncomedocsOutStock($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        $cashAccount = $cashBankAccountData->outCash($sysBankid, $bankType, $out, $date);

        //写入流水
        $journalNo = $this->add('', $jobNo, $amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
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
        } elseif ($bankType ==BankAccountData::TYPE_ESCROW) {
            $cashAccount = $cashBankAccountData->saveTypeCashPending($sysBankid, $amount, $amount, $bankType, $date);
        }
        

        //写入流水
        $journalNo = $this->add('', $jobNo, -$amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
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
    public function ThirdPartyRechargeFalse($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        if ($bankType == BankAccountData::TYPE_STOCK_FUND) {
            $cashAccount = $cashBankAccountData->saveTypeCashPending($sysBankid, $amount, $amount, $bankType, $date);
        } elseif ($bankType == BankAccountData::TYPE_ESCROW) {
            $cashAccount = $cashBankAccountData->saveTypePendingLess($sysBankid, $amount, $bankType, $date);
        }
        

        //写入流水
        $journalNo = $this->add('', $jobNo, -$amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
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
    public function ThirdPartyRechargeIncomedocs($jobNo, $sysBankid, $amount, $type, $status, $in, $out, $date, $bankType)
    {
        //增加平台托管账户
        $cashBankAccountData = new BankAccountData();

        //查询有没有这个账户
        $cashBankAccountData->isEXistence($sysBankid, $bankType);

        
        $cashAccount = $cashBankAccountData->saveTypePending($sysBankid, $amount, $bankType, $date);

        //写入流水
        $journalNo = $this->add('', $jobNo, $amount, $cashAccount, $type, $status, $in, $out, $date, $sysBankid);
        return $journalNo;
    }
}
