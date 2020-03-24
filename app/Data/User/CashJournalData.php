<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CashJournalAdapter;

class CashJournalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\User\CashJournal';

    protected $no = 'usercash_journal_no';

    
    const STATUS_APPLY = 'CJT01';
    const STATUS_SUCCESS = 'CJT02';
    const STATUS_FAULT = 'CJT03';
    const REVOKE_STATUS = 'CJT04';
    const ORDER_STATUS = 'CJT06';
    const STATUS_VOUCHER = 'CJT07';
    const REBATE_STATUS = 'CJT08';
    const BONUS_STATUS = 'CJT09';
    const FROZEN_STATUS = 'CJT10';
    const UNFROZEN_STATUS = 'CJT11';
    const BUY_ORDER_RETREAT_STATUS = 'CJT13';
    const CLEAR_STATUS = "CJT99";

    const WITHDRAWAL_TYPE = 'CJ01';
    const RECHARGE_TYPE = 'CJ02';
    const TRANSACTION_BUY_TYPE = 'CJ03';
    const WITHDRAWAL_FEE_TYPE = 'CJ05';
    const TRANSACTION_ORDER_COUPONS_TYPE = 'CJ08';
    const TYPE_Third_RECHARGE = 'CJ12';
    const TYPE_VOUCHER = 'CJ13';
    const REBATE_TYPE = 'CJ14';
    const BONUES_TYPE = 'CJ15';
    const FROZEN_TYPE = 'CJ16';
    const UNFROZEN_TYPE = 'CJ17';
    const BUY_ORDER_RETREAT_TYPE = 'CJ18';
    const CLEAR_TYPE = "CJ99";  //清算


    /**
     * 挂买单时写入用户流水表
     *
     * @param   $userCashAccountRes 用户现金余额表数据
     * @param   $userCashJournalNo 用户现金流水表单据号
     * @param   $amount 在途金额
     * @param   $transactionBuyNo 买单单据号 关联单据号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addUserCashJournal($userCashAccountRes, $userCashJournalNo, $amount, $transactionBuyNo, $type = 'CJ03', $status = 'CJT01')
    {
        $docNo = new DocNoMaker();
        $userCashJournalNo = $docNo->Generate('UCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $this->session->userid;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_no = $userCashJournalNo;
        $model->usercash_journal_datetime = date('Y-m-d H:i:s');
        $model->usercash_journal_pending = $amount;
        $model->usercash_journal_type = $type;
        $model->usercash_journal_jobno = $transactionBuyNo;
        $model->usercash_journal_status = $status;
        return $docMd5->AddHash($model);
    }

    /**
     * 撤销买单 写入用户流水表
     *
     * @param   $amount  金额
     * @param   $userCashAccountRes 用户现金余额表数据
     * @param   $userCashJournalNo 用户现金流水表单据号
     * @param   $transactionBuyNo 买单单据号
     * @param   $userid  用户id
     * @param   $type 状态
     * @param   $status
     * @author  zhoutao
     * @version 0.1
     */
    public function revokeAddUserJournal($amount, $userCashAccountRes, $userCashJournalNo, $transactionBuyNo, $userid = null, $type = 'CJ03', $status = 'CJT04', $date = null)
    {
        $docNo = new DocNoMaker();
        $userCashJournalNo = $docNo->Generate('UCJ');
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $userid;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_no = $userCashJournalNo;
        $model->usercash_journal_datetime = $date;
        $model->usercash_journal_pending = -$amount;
        $model->usercash_journal_type = $type;
        $model->usercash_journal_jobno = $transactionBuyNo;
        $model->usercash_journal_status = $status;
        return $docMd5->AddHash($model);
    }

    /**
     * 增加用户现金流水表 减少在途，增加收入
     *
     * @param   $userJournalNo 流水单据号
     * @param   $amount 金额
     * @param   $rechargeNo 关联单据号
     * @param   $userCashAccountRes 用户信息
     * @param   $uesrid 用户id
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addUserIn($userJournalNo, $amount, $rechargeNo, $userCashAccountRes, $uesrid = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($uesrid === null) {
            $uesrid = $this->session->userid;
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $uesrid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = date('Y-m-d H:i:s');
        $model->usercash_journal_in = $amount;
        $model->usercash_journal_pending = -$amount;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = 'CJ02';
        $model->usercash_journal_jobno = $rechargeNo;
        $model->usercash_journal_status = 'CJT02';
        return $docMd5->AddHash($model);
    }


    /**
     * 增加用户现金流水表 增加收入
     *
     * @param   $userJournalNo 流水单据号
     * @param   $amount 金额
     * @param   $rechargeNo 关联单据号
     * @param   $userCashAccountRes 用户信息
     * @param   $uesrid 用户id
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addUserInTwo($userJournalNo, $amount, $rechargeNo, $userCashAccountRes, $uesrid = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($uesrid === null) {
            $uesrid = $this->session->userid;
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $uesrid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = date('Y-m-d H:i:s');
        $model->usercash_journal_in = $amount;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = 'CJ02';
        $model->usercash_journal_jobno = $rechargeNo;
        $model->usercash_journal_status = 'CJT02';
        return $docMd5->AddHash($model);
    }

    /**
     * 增加用户现金流水表 在途和支出 +
     *
     * @param  $userJournalNo 用户流水单据号
     * @param  $withdrawalNo 提现单据号
     * @param  $userCashAccountRes 用户账户信息
     * @param  $userjournalAmount 支出和在途金额
     * @param  string                                  $type   类型
     * @param  string                                  $status 状态
     * @return bool
     */
    public function addJournalWith($userJournalNo, $withdrawalNo, $userCashAccountRes, $userjournalAmount, $type = 'CJ01', $status = 'CJT01', $date = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $this->session->userid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = date('Y-m-d H:i:s');
        $model->usercash_journal_pending = $userjournalAmount;
        $model->usercash_journal_out = $userjournalAmount;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = $type;
        $model->usercash_journal_jobno = $withdrawalNo;
        $model->usercash_journal_status = $status;
        return $docMd5->AddHash($model);
    }

    /**
     * 用户流水表 平掉在途
     *
     * @param  $userJournalNo
     * @param  $withdrawalNo
     * @param  $userCashAccountRes
     * @param  $pending
     * @param  null               $userid
     * @return bool
     */
    public function addJournalTrueWith($userJournalNo, $withdrawalNo, $userCashAccountRes, $pending, $userid = null, $date = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $userid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = $date;
        $model->usercash_journal_pending = $pending;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = 'CJ01';
        $model->usercash_journal_jobno = $withdrawalNo;
        $model->usercash_journal_status = 'CJT02';
        return $docMd5->AddHash($model);
    }

    /**
     * 用户流水表 平掉在途
     *
     * @param  $userJournalNo
     * @param  $withdrawalNo
     * @param  $userCashAccountRes
     * @param  $pending
     * @param  null $userid
     * @return bool
     */

                   //addJournalTrueWithTwo($userJournalNo,$withdrawalRate,$withdrawalNo,$userCashRes,$userId)
    public function addJournalTrueWithTwo($userJournalNo, $withdrawalNo, $userCashAccountRes, $pending, $userid = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $userid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = date('Y-m-d H:i:s');
        $model->usercash_journal_pending = $pending;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];//accountPending
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = 'CJ05';
        $model->usercash_journal_jobno = $withdrawalNo;
        $model->usercash_journal_status = 'CJT02';
        return $docMd5->AddHash($model);
    }

    /**
     * 添加用户现金流水
     *
     * @param   $userJournalNo 流水单据号
     * @param   $withdrawalNo 关联单据号
     * @param   $userCashAccountRes 用户现金账户
     * @param   $pending 在途
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                                   $in     收入
     * @param   int                                   $out    支出
     * @param   null                                  $userid 用户id
     * @param   null                                  $date   日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function add($userJournalNo, $withdrawalNo, $userCashAccountRes, $pending, $type, $status, $in = 0, $out = 0, $userid = null, $date = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $userid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = $date;
        $model->usercash_journal_pending = $pending;
        $model->usercash_journal_in = $in;
        $model->usercash_journal_out = $out;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = $type;
        $model->usercash_journal_jobno = $withdrawalNo;
        $model->usercash_journal_status = $status;
        return $docMd5->AddHash($model);
    }

    /**
     * 添加用户现金流水
     *
     * @param   $userJournalNo 流水单据号
     * @param   $withdrawalNo 关联单据号
     * @param   $userCashAccountRes 用户现金账户
     * @param   $pending 在途
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                                   $in     收入
     * @param   int                                   $out    支出
     * @param   null                                  $userid 用户id
     * @param   null                                  $date   日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function addCash($userJournalNo, $withdrawalNo, $userCashAccountRes, $pending, $type, $status, $in = 0, $out = 0, $userid = null, $date = null)
    {
        $docNo = new DocNoMaker();
        $userJournalNo = $docNo->Generate('UCJ');
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        $docMd5 = new DocMD5Maker();
        $model = $this->newitem();
        $model->usercash_journal_userid = $userid;
        $model->usercash_journal_no = $userJournalNo;
        $model->usercash_journal_datetime = $date;
        $model->usercash_journal_pending = $pending;
        $model->usercash_journal_in = $in;
        $model->usercash_journal_out = $out;
        $model->usercash_result_pending = $userCashAccountRes['accountPending'];
        $model->usercash_result_cash = $userCashAccountRes['accountCash'];
        $model->usercash_journal_type = $type;
        $model->usercash_journal_jobno = $withdrawalNo;
        $model->usercash_journal_status = $status;
        $docMd5->AddHash($model);
        return $userJournalNo;
    }

    public function getJournalList($pageSize, $pageIndex)
    {
        $model = $this->newitem();
        $tmp = $model::where('usercash_journal_userid', $this->session->userid)->where('usercash_journal_pending', '>=', 0);

        $result['totalSize'] = $tmp->count();
        $tmp = $tmp->orderBy('id', 'desc');
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        return $result;
    }

    /**
     * 第三方充值支付
     *
     * @param   $withdrawalNo 关联单据号
     * @param   $pending 在途金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                          $in     收入
     * @param   int                          $out    支出
     * @param   null                         $userid 用户id
     * @param   null                         $date   日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdUesrRechargePayment($withdrawalNo, $pending, $type, $status, $in = 0, $out = 0, $userid = null, $date = null)
    {
        //修改用户账户余额
        $cashAccountData = new CashAccountData();
        $userCashAccountRes = $cashAccountData->savePendingCash($pending);

        //写入流水
        $journalNo = $this->add('', $withdrawalNo, $userCashAccountRes, $pending, $type, $status, $in, $out, $userid, $date);
        return $journalNo;
    }

    /**
     * 第三方充值支付确认
     *
     * @param   $withdrawalNo 关联单据号
     * @param   $pending 在途金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                          $in     收入
     * @param   int                          $out    支出
     * @param   null                         $userid 用户id
     * @param   null                         $date   日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdUesrRechargePaymentTrue($withdrawalNo, $pending, $type, $status, $in = 0, $out = 0, $userid = null, $date = null)
    {
        //修改用户账户余额
        $cashAccountData = new CashAccountData();
        $userCashAccountRes = $cashAccountData->saveUserCashAccount($pending, $userid, $date);

        //写入流水
        $journalNo = $this->add('', $withdrawalNo, $userCashAccountRes, -$pending, $type, $status, $in, $out, $userid, $date);
        return array_get($userCashAccountRes, 'accountCash');
    }

    /**
     * 第三方充值支付失败
     *
     * @param   $withdrawalNo 关联单据号
     * @param   $pending 在途金额
     * @param   $type 类型
     * @param   $status 状态
     * @param   int                          $in     收入
     * @param   int                          $out    支出
     * @param   null                         $userid 用户id
     * @param   null                         $date   日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function ThirdUesrRechargePaymentFalse($withdrawalNo, $pending, $type, $status, $in = 0, $out = 0, $userid = null, $date = null)
    {
        //修改用户账户余额
        $cashAccountData = new CashAccountData();
        $userCashAccountRes = $cashAccountData->savePendingShao($pending, $userid, $date);

        //写入流水
        $journalNo = $this->add('', $withdrawalNo, $userCashAccountRes, -$pending, $type, $status, $in, $out, $userid, $date);
        return $journalNo;
    }

    /**
     * 查询用户余额
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getCashToday($userid,$start,$end)
    {
        //$where['account_userid'] = $userid;
        $model=$this->newitem();
        $info = $model->orderBy('usercash_journal_datetime', 'desc')
            ->whereBetween('usercash_journal_datetime', [$start,$end])
            ->where('usercash_journal_userid', $userid)
            ->first();
        if ($info == null) {
            return 0;
        }
        return $info->usercash_result_cash;
    }

    /**
     * 查询用户在途资金
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getPendingToday($userid,$start,$end)
    {
        //$where['account_userid'] = $userid;
        $model=$this->newitem();
        $info = $model->orderBy('usercash_journal_datetime', 'desc')
            ->whereBetween('usercash_journal_datetime', [$start,$end])
            ->where('usercash_journal_userid', $userid)
            ->first();
        if ($info == null) {
            return 0;
        }
        return $info->usercash_result_pending;
    }
}
