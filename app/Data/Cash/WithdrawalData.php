<?php
namespace App\Data\Cash;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\Sys\CashData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as userCashJournalData;
use App\Data\Sys\CashJournalData;
use App\Data\Cash\BankAccountData;
use App\Data\Cash\RechargeData;
use App\Data\Cash\JournalData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\SendSmsData;
use iscms\AlismsSdk\TopClient;
use iscms\Alisms\SendsmsPusher;
use App\Data\User\UserData;

class WithdrawalData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Cash\Withdrawal';

    protected $no = 'cash_withdrawal_no';

    const APPLY_STATUS = 'CW00'; //申请
    const SUCCESS_STATUS = 'CW01'; //成功
    const FAIL_STATUS = 'CW02'; //失败

    /**
     * 发起提现 写入提现表
     *
     * @param   $withdrawalNo 提现单据号
     * @param   $amount 金额
     * @param   $fromBankId 提现银行卡号
     * @param   $toBankId 提现到银行卡号
     * @param   $fee 手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function add($amount, $fromBankId, $toBankId, $fee, $withdrawalRate, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $withdrawalNo = $docNo->Generate('CW');
        $model = $this->newitem();
        $model->cash_withdrawal_no = $withdrawalNo;
        $model->cash_withdrawal_amount = $amount;
        $model->cash_withdrawal_status = 'CW00';
        $model->cash_withdrawal_userid = $this->session->userid;
        $model->cash_withdrawal_bankid = $fromBankId;
        $model->cash_withdrawal_time = $date;
        $model->cash_withdrawal_srcbankid = $toBankId;
        $model->cash_withdrawal_type = 'CWT01';
        $model->cash_withdrawal_rate = $withdrawalRate;
        $model->cash_withdrawal_fee = $fee;
        $model->cash_withdrawal_out = $amount - $fee;
        $this->create($model);
        return $withdrawalNo;
    }

    /**
     * 发起提现 写入提现表
     *
     * @param   $amount 金额
     * @param   $fromBankId 提现银行卡号
     * @param   $toBankId 提现到银行卡号
     * @param   $fee 手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addWithdrawal($amount, $fromBankId, $toBankId, $fee, $withdrawalRate, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $withdrawalNo = $docNo->Generate('CW');
        $model = $this->newitem();
        $model->cash_withdrawal_no = $withdrawalNo;
        $model->cash_withdrawal_amount = $amount;
        $model->cash_withdrawal_status = 'CW00';
        $model->cash_withdrawal_userid = $this->session->userid;
        $model->cash_withdrawal_bankid = $fromBankId;
        $model->cash_withdrawal_time = $date;
        $model->cash_withdrawal_srcbankid = $toBankId;
        $model->cash_withdrawal_type = 'CWT01';
        $model->cash_withdrawal_rate = $withdrawalRate;
        $model->cash_withdrawal_fee = $fee;
        $model->cash_withdrawal_out = $amount - $fee;
        $model->save();
        return $withdrawalNo;
    }

    public function getWith($no)
    {
        $where['cash_withdrawal_no'] = $no;
        return $this->find($where);
    }

    /**
     * 更新提现为成功
     *
     * @param  $withdrawalNo 提现单号
     * @author zhoutao
     * @date   2017.11.24
     */
    public function successWith($withdrawalNo)
    {
        $date = date('Y-m-d H:i:s');
        $withdrawal = $this->getByNo($withdrawalNo);
        $withdrawal->cash_withdrawal_chkuserid = $this->session->userid;
        $withdrawal->cash_withdrawal_chktime = $date;
        $withdrawal->cash_withdrawal_success = 1;
        $withdrawal->cash_withdrawal_status = self::SUCCESS_STATUS;
        $this->save($withdrawal);
    }

    /**
     * 更新提现为失败
     *
     * @param  $withdrawalNo 提现单号
     * @param  $body 描述
     * @author zhoutao
     * @date   2017.11.24
     */
    public function failWith($withdrawalNo, $body)
    {
        $date = date('Y-m-d H:i:s');
        $withdrawal = $this->getByNo($withdrawalNo);
        $withdrawal->cash_withdrawal_chkuserid = $this->session->userid;
        $withdrawal->cash_withdrawal_chktime = $date;
        $withdrawal->cash_withdrawal_success = 0;
        $withdrawal->cash_withdrawal_status = self::FAIL_STATUS;
        $withdrawal->cash_withdrawal_body = $body;
        $this->save($withdrawal);
    }

    public function getUserWithCash($userid, $status,$start,$end)
    {
        $where['cash_withdrawal_userid'] = $userid;
        $where['cash_withdrawal_status'] = $status;
        $model = $this->modelclass;
        return $model::where($where)
        ->whereBetween('cash_withdrawal_time', [$start,$end])
        ->get();
    }

    public function getUserWithCashs($userid, $status)
    {
        $where['cash_withdrawal_userid'] = $userid;
        $where['cash_withdrawal_status'] = $status;
        $model = $this->modelclass;
        return $model::where($where)->sum('cash_withdrawal_amount');
    }

    /**
     * 查询一段时间内提现数量
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getWithdrawalCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = $model->whereBetween('created_at', [$start,$end])
            ->count();
        return $total;
    }

    /**
     * 查询一段时间内提现成功总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getCashCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = $model->whereBetween('updated_at', [$start,$end])->where('cash_withdrawal_success', 1)
            ->sum('cash_withdrawal_amount');
        return $total;
    }

    /**
     * 查询一段时间内提现人次
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getInvCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = $model->whereBetween('created_at', [$start,$end])
            ->groupBy('order_buy_userid')
            ->count();
        return $total;
    }

    /**
     * 查询迄今为止提现未审核笔数
     *
     * @param  $end 结束时间
     * @author liu
     */
    public function getUncheckCountDaily($end)
    {
        $model = $this->newitem();
        $total = $model->where('created_at', '<', $end)
            ->where('cash_withdrawal_status', 'CW00')
            ->count();
        return $total;
    }

    // public function notifycreateddefaultrun($data){
        
    // }
        
    // public function notifysaveddefaultrun($data){
    //     $smsVerifyFac=new SmsVerifyFactory();
    //     $sendSmsData=new SendSmsData();
    //     $userData=new UserData();
    //     $cashAccountData=new CashAccountData();

    //     $userId=$data['cash_withdrawal_userid'];
    //     $userInfo=$userData->get($userId);
    //     if(!$userInfo->user_name)   
    //     {
    //         $name="用户";
    //     }
    //     else
    //     {
    //         $name=$userInfo->user_name;
    //     }
    //     $phone=$userInfo->user_mobile;
    //     $money=$data['cash_withdrawal_useramount'];
    //     $user=$cashAccountData->getitem()->where('account_userid',$userId)->account_cash;
    //     $no=$data["cash_withdrawal_no"];

    //     $verify = $fac->CreateVerify();
    //     $verify->SendWithdrawalNotify($phone, $no, $userName, $money, $user);
    //     return true;
    // }

    // public function notifydeleteddefaultrun($data){

    // }
}
