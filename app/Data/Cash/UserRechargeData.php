<?php
namespace App\Data\Cash;

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
use App\Data\Schedule\IDaySchedule;

class UserRechargeData extends IDatafactory implements IDaySchedule
{

    /**充值操作
     * @param $amount 充值金额
     * @param $bankId 银行卡id
     * @param $desbankId 银行卡id
     * @param $docMd5 md5类
     * @param $rechargeNo 充值单据号
     * @param $journaNo 流水单据号
     * @param $userJournalNo 用户流水单据号
     * @author zhoutao
     * @version 0.1
     */
    const TYPE_EACH='FRT01';
    const TYPE_TOTAL='FRT02';
    const TYPE_STEP='FRT00';

    const TYPE_ROUTE_NONE='FRR00';
    const TYPE_ROUTE_ROUND='FRR01';
    const TYPE_ROUTE_UP='FRR02';
    const TYPE_ROUTE_DOWN='FRR03';

    const RECHARGE_EVENT_TYPE = 'Recharge_Check';

    public function changeRechargeAmount($rechargeNo, $ammount)
    {

               //查找充值表
        $cashRechageData = new RechargeData();
        $rechargeInfo = $cashRechageData->getRecharge($rechargeNo);

        $rechargeInfo -> cash_recharge_amount = $ammount;

        $this->save($rechargeInfo);
    }


    public function flowRecharge($rechargeNo)
    {

               //查找充值表
        $cashRechageData = new RechargeData();
        $rechargeInfo = $cashRechageData->getRecharge($rechargeNo);

        $rechargeInfo -> cash_recharge_amount = floor($rechargeInfo -> cash_recharge_amount);//$amount;
        

        $this->save($rechargeInfo);
    }

    /**
     * 第三方充值事务
     * @param $amount 金额
     * @param $channelid 通道
     * @param $bankCard 银行卡
     * @author zhoutao
     * @date 2017.11.23
     */
    public function thirdRecharge($amount, $channelid, $bankCard = '')
    {
        $date = date('Y-m-d H:i:s');
        $userid = $this->session->userid;

        //查询通道
        $channelData = new PayChannelData();
        $channelInfo = $channelData->get($channelid);
        if (empty($channelInfo)) {
            $res['success'] = false;
            $res['code'] = 812001;
            $res['msg'] = '';
            return $res;
        }
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

        //查询用户手机号
        $userData = new UserData();
        $userInfo = $userData->getUser($userid);
        $mobile = $userInfo->user_mobile;

        //写入充值
        $rechargeData = new RechargeData();
        $rechargeNo = $rechargeData->addRecharge($mobile, $amount, $bankCard, $sysBankid, $date, RechargeData::THIRDPAYMENT_TYPE, $channelid);

         //写入用户资金 在途增加
         $userCashAccountData = new CashAccountData;
         $userCashAccountData->increasePending($rechargeNo, $amount, $userid, CashJournalData::TYPE_Third_RECHARGE, CashJournalData::STATUS_APPLY, $date);

         //写入平台托管账户
         $bankAccountData = new BankAccountData;
         
         $bankAccountData->increasePending(BankAccountData::TYPE_ESCROW,$rechargeNo,$amount,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,$date, $trusteeshipBankid);

         //写入平台备付金账户         
         $bankAccountData->reduceCashIncreasePending(BankAccountData::TYPE_STOCK_FUND, $rechargeNo, $amount, $amount, SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY, $date, $provisionsBankid);

        //返回
        $payChannelMethodsData = new PayChannelMethodData();
        $payMethodsid = $payChannelMethodsData->getMethodsid($channelid);

        $payMethodsData = new PayMethodsData();
        $paymethodsInfo = $payMethodsData->get($payMethodsid);

        $payMethodsAdapter = new PayMethodsAdapter();
        $paymethodsInfo = $payMethodsAdapter->getDataContract($paymethodsInfo);
        $paymethodsInfo = array_add($paymethodsInfo, 'accessid', $payAccessid);
        $paymethodsInfo = array_add($paymethodsInfo, 'accesskey', $payAccesskey);
        $paymethodsInfo = array_add($paymethodsInfo, 'rechargeNo', $rechargeNo);

        $res['success'] = true;
        $res['code'] = 0;
        $res['msg'] = $paymethodsInfo;
        return $res;
        
    }

    /**
     * 第三方充值确认
     * @param $rechargeNo 充值单号
     * @author zhoutao
     * @date 2017.11.23
     */
    public function thirdRechargeTrue($rechargeNo)
    {
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

            //写入用户资金 在途减少 余额增加
            $userCashAccountData = new CashAccountData;
            
            $userCashRes = $userCashAccountData->increaseCashReducePending($rechargeNo, $amount, $amount, $userid, CashJournalData::TYPE_Third_RECHARGE, CashJournalData::STATUS_SUCCESS, $date); 
            $balance = array_get($userCashRes, 'accountCash');

            //写入平台托管账户
            $bankAccountData = new BankAccountData();
            
            $bankAccountData->increaseCashReducePending(BankAccountData::TYPE_ESCROW, $rechargeNo, $amount, $amount, SysCashJournalData::TYPE_Third_RECHARGE, SysCashJournalData::STATUS_SUCCESS, $date, $trusteeshipBankid);

            //写入平台备付金账户
            $bankAccountData->reducePending(BankAccountData::TYPE_STOCK_FUND,$rechargeNo,$amount,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_SUCCESS,$date, $provisionsBankid);

            //更新充值表
            $rechargeData->saveRecharge($rechargeNo, 1, 0, $date);

            //写入用户现金记录
            $userCashOrderData = new CashOrderData();
            $userCashOrderData->add($rechargeNo, $amount, CashOrderData::RECHARGE_TYPE, $balance, $userid);

            //通知用户
            $this->AddEvent(self::RECHARGE_EVENT_TYPE, $userid, $rechargeNo);
        }

        $res['success'] = true;
        $res['code'] = 0;
        $res['msg'] = $rechargeNo;
        return $res;
    }


    /**
      * 第三方冲值入账
     *
      * @param   $startTime 开始时间
      * @param   $endTime 结束时间
      * @param   $channelid 通道id
      * @author  zhoutao
      * @version 0.1
      */
    //2017.8.10 修复手续费最小值bug liu
    public function ThirdPartyRechargeIncomedocs($startTime, $endTime, $channelid)
    {

        $rechargeData = new RechargeData();
        $incomedocsData = new PayIncomedocsData();

        $filter = [
              "income_starttime" =>$startTime,
              "income_endtime" => $endTime,
              "income_3rdchannel" => $channelid,

        ];

        $item = $incomedocsData->find($filter);

        if ($item!=null) {
            return ;
        }
        

        //查询充值总额
        $rechargeAmount = $rechargeData->getRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_CONFIRMED,$channelid);
        // var_dump($rechargeAmount);
        $rechargeAmountArray = $rechargeData->getEachRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_CONFIRMED,$channelid);

        $date = date('Y-m-d H:i:s');

        //查询通道
        $channelData = new PayChannelData();
        $channelInfo = $channelData->get($channelid);
        $payplatformid = $channelInfo->channel_payplatform; //pay id
        $infeeRate = $channelInfo->channel_infeerate; //入账手续费率
        $infeeType = $channelInfo->channel_infeetype; //入帐手续费类型
        $withBankNo = $channelInfo->channel_withdralbankno; //提现账号
        $infeeCountType = $channelInfo->channel_infeecounttype;//入帐手续费结算类型
        $infeeRouteType = $channelInfo->channel_infeeroutetype;//入账手续费舍入方式
        $infeeMinCount = $channelInfo->channel_infeemincount;//入账手续费最小金额
        if($infeeMinCount==null)
        {
            $infeeMinCount=0;
        }
        $infee=0;
        //结算方式判断
        switch($infeeCountType)
        {
            case self::TYPE_EACH:
            {
                foreach($rechargeAmountArray as $value){
                    //舍入方式判断
                    switch($infeeRouteType)
                    {
                        case self::TYPE_ROUTE_ROUND:
                        {
                            $tmpInfee=round($value * $infeeRate,2);
                            if($tmpInfee < $infeeMinCount)
                            {
                                $infee= $infee + $infeeMinCount;
                            }
                            else
                            {
                                $infee= $infee + $tmpInfee;
                            }
                            break;
                        }
                        case self::TYPE_ROUTE_UP:
                        {
                            $tmpInfee=ceil($value * $infeeRate);
                            if($tmpInfee < $infeeMinCount)
                            {
                                $infee= $infee + $infeeMinCount;
                            }
                            else
                            {
                                $infee= $infee + $tmpInfee;
                            }
                            break;
                        }
                        case self::TYPE_ROUTE_DOWN:
                        {
                            $tmpInfee=floor($value * $infeeRate);
                            if($tmpInfee < $infeeMinCount)
                            {
                                $infee= $infee + $infeeMinCount;
                            }
                            else
                            {
                                $infee= $infee + $tmpInfee;
                            }
                            break;
                        }
                        case self::TYPE_ROUTE_NONE:
                        {
                            $tmpInfee=$value * $infeeRate;
                            if($tmpInfee < $infeeMinCount)
                            {
                                $infee= $infee + $infeeMinCount;
                            }
                            else
                            {
                                $infee= $infee + $tmpInfee;
                            }
                            break;
                        }
                        //默认四舍五入
                        default:
                        {
                            $tmpInfee=round($value * $infeeRate,2);
                            if($tmpInfee < $infeeMinCount)
                            {
                                $infee= $infee + $infeeMinCount;
                            }
                            else
                            {
                                $infee= $infee + $tmpInfee;
                            }
                            break;
                        }         
                    }
                    
                }//累加得到总手续费
                //$infee = $rechargeAmount * $infeeRate;
                $rechargeAmount -= $infee;
                break;
            }
            case self::TYPE_TOTAL:
            {
                $infee = $rechargeAmount * $infeeRate;
                if($infee < $infeeMinCount)
                {
                    $infee=$infeeMinCount;
                }
                $rechargeAmount -= $infee;
                break;
            }
            //直接跳出，不执行入账
            case self::TYPE_STEP:
            {
                // $infee = $rechargeAmount * $infeeRate;
                // $rechargeAmount -= $infee;
                exit;
                break;
            }
            //默认为汇总计算
            default:
            {
                $infee = $rechargeAmount * $infeeRate;
                if($infee < $infeeMinCount)
                {
                    $infee=$infeeMinCount;
                }
                $rechargeAmount -= $infee;
                break;
            }
        }

        //查询平台
        $payData = new PayData();
        $payInfo = $payData->get($payplatformid);
        $sysBankid = $payInfo->pay_withdrawalbankno; //系统银行账号
        $provisionsBankid = $payInfo->pay_provisions; //备付金账号
        $trusteeshipBankid = $payInfo->pay_trusteeship; //托管账户
        $payAccessid = $payInfo->pay_accessid;  //id
        $payAccesskey = $payInfo->pay_accesskey; //key

        // dump($rechargeAmount);
        DB::beginTransaction();

        //添加入帐

        $incomedocsInfo = $incomedocsData->add($payplatformid,$channelid,$withBankNo,$provisionsBankid,
        $rechargeAmount,$infeeRate,$infee,PayIncomedocsData::TYPE_DEFUALT,PayIncomedocsData::STATUS_APPLY,
        $startTime,$endTime);
        // dump("complete");
        $jobNo = $incomedocsInfo->income_no;
        // var_dump($jobNo);

         //写入平台托管账户
         $sysJournalData = new SysCashJournalData();
         $sysJournalData->ThirdPartyRechargeEscrow($jobNo,$trusteeshipBankid,$rechargeAmount,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,0,0,$date,BankAccountData::TYPE_ESCROW);

         //写入资金池账户
         $journalData = new JournalData();
         $journalData->ThirdPartyRechargeIncomedocs($jobNo,$sysBankid,$rechargeAmount,CashJournalData::TYPE_Third_RECHARGE,CashJournalData::STATUS_APPLY,0,0,$date);

         //更新充值表
         $rechargeData->saveRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_ACCOUNTED_FOR,RechargeData::STATUS_CONFIRMED,$date,$channelid);

         DB::commit();
        //  dump("complete");
     } 



    /**
      * 第三方冲值入账审核
      *
      * @param   $incomedocsNo 入账单据号
      * @author  zhoutao
      * @version 0.1
      *
      * 增加了锁
      * @author zhoutao
      * @date 2017.9.26
      * 
      * 修改了 redis key
      * @author zhoutao
      * @date 2017.10.10
      */
    public function ThirdPartyRechargeIncomedocsTrue($incomedocsNo)
    {
        $lk = new LockData();
        $key = 'confirmIncomedocs' . $incomedocsNo;
        $lk->lock($key);

        DB::beginTransaction();

        $rechargeData = new RechargeData();
        $userid = $this->session->userid;

        //查询入帐
        $incomedocsData = new PayIncomedocsData();
        $incomedocsInfo = $incomedocsData->getByNo($incomedocsNo);
		if($incomedocsInfo===null)
		{
			return null;
		}
        $channelid = $incomedocsInfo->income_3rdchannel;
        $payplatformid = $incomedocsInfo->income_3rdpay;
        $rechargeAmount = $incomedocsInfo->income_cash;
        $startTime = $incomedocsInfo->income_starttime;
        $endTime = $incomedocsInfo->income_endtime;
        $infee = $incomedocsInfo->income_fee;
        $channelid=$incomedocsInfo->income_3rdchannel;

        //查询充值总额
        $amount = $rechargeData->getRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_ACCOUNTED_FOR,$channelid);

        $date = date('Y-m-d H:i:s');

        

        // //查询通道
        // $channelData = new PayChannelData();
        // $channelInfo = $channelData->get($channelid);
        // $payplatformid = $channelInfo->channel_payplatform; //pay id
        // $infeeRate = $channelInfo->channel_infeerate; //入账手续费率
        // $infeeType = $channelInfo->channel_infeetype; //入帐手续费类型
        // $withBankNo = $channelInfo->channel_withdralbankno; //提现账号
        // $infee = $amount * $infeeRate;
        // $rechargeAmount = $amount - $infee;

        //查询平台
        $payData = new PayData();
        $payInfo = $payData->get($payplatformid);
        $sysBankid = $payInfo->pay_withdrawalbankno; //系统银行账号
        $provisionsBankid = $payInfo->pay_provisions; //备付金账号
        $trusteeshipBankid = $payInfo->pay_trusteeship; //托管账户

        

         //写入平台托管账户
         $sysJournalData = new SysCashJournalData();
         $sysJournalData->IncomedocsInEscrow($incomedocsNo,$trusteeshipBankid,$rechargeAmount,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,$rechargeAmount,0,$date,BankAccountData::TYPE_ESCROW);

         //给备付金
         $sysJournalData->IncomedocsOutStock($incomedocsNo,$trusteeshipBankid,0,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,0,$rechargeAmount,$date,BankAccountData::TYPE_ESCROW);

         //备付金收入
         $sysJournalData->IncomedocsIn($incomedocsNo,$provisionsBankid,0,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,$amount,0,$date,BankAccountData::TYPE_STOCK_FUND);

         //备付金支出手续费
         $sysJournalData->IncomedocsOutStock($incomedocsNo,$provisionsBankid,0,SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY,0,$infee,$date,BankAccountData::TYPE_STOCK_FUND);

         //写入资金池账户
         $journalData = new JournalData();
         $journalData->ThirdPartyRechargeIncomedocsTrue($incomedocsNo,$sysBankid,$rechargeAmount,CashJournalData::TYPE_Third_RECHARGE,CashJournalData::STATUS_APPLY,$rechargeAmount,0,$date);

         //更新充值表
         $rechargeData->saveRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_ARRIVAL,RechargeData::STATUS_ACCOUNTED_FOR,$date, $channelid);

         //更新入账
         $incomedocsData->saveStatus($incomedocsNo,PayIncomedocsData::STATUS_ARRIVAL,$userid,$date);

        DB::commit();
        $lk->unlock($key);
    }

    /**
      * 第三方冲值入账拒绝
      *
      * @param   $incomedocsNo 入账单据号
      * @author  zhoutao
      * @date 17.8.10
      * @version 0.1
      * 
      * 增加了锁
      * @author zhoutao
      * @date 2017.9.26
      *
      * 修改了 redis key
      * @author zhoutao
      * @date 2017.10.10
      */
    public function ThirdPartyRechargeIncomedocsFalse($incomedocsNo)
    {
        $lk = new LockData();
        $key = 'confirmIncomedocs' . $incomedocsNo;
        $lk->lock($key);

        DB::beginTransaction();
        $rechargeData = new RechargeData();
        $userid = $this->session->userid;

        //查询入帐
        $incomedocsData = new PayIncomedocsData();
        $incomedocsInfo = $incomedocsData->getByNo($incomedocsNo);
		if(empty($incomedocsInfo))
		{
			return null;
		}
        $channelid = $incomedocsInfo->income_3rdchannel;
        $payplatformid = $incomedocsInfo->income_3rdpay;
        $rechargeAmount = $incomedocsInfo->income_cash;
        $startTime = $incomedocsInfo->income_starttime;
        $endTime = $incomedocsInfo->income_endtime;
        $infee = $incomedocsInfo->income_fee;
        $channelid=$incomedocsInfo->income_3rdchannel;

        //查询充值总额
        $amount = $rechargeData->getRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_ACCOUNTED_FOR,$channelid);

        $date = date('Y-m-d H:i:s');

        

        // //查询通道
        // $channelData = new PayChannelData();
        // $channelInfo = $channelData->get($channelid);
        // $payplatformid = $channelInfo->channel_payplatform; //pay id
        // $infeeRate = $channelInfo->channel_infeerate; //入账手续费率
        // $infeeType = $channelInfo->channel_infeetype; //入帐手续费类型
        // $withBankNo = $channelInfo->channel_withdralbankno; //提现账号
        // $infee = $amount * $infeeRate;
        // $rechargeAmount = $amount - $infee;

        //查询平台
        $payData = new PayData();
        $payInfo = $payData->get($payplatformid);
        $sysBankid = $payInfo->pay_withdrawalbankno; //系统银行账号
        $provisionsBankid = $payInfo->pay_provisions; //备付金账号
        $trusteeshipBankid = $payInfo->pay_trusteeship; //托管账户

        

         //写入平台托管账户
         $sysJournalData = new BankAccountData();
         $sysJournalData->reducePending(BankAccountData::TYPE_ESCROW, $incomedocsNo, $rechargeAmount, SysCashJournalData::TYPE_Third_RECHARGE,SysCashJournalData::STATUS_APPLY, $date, $trusteeshipBankid);

         //写入资金池账户
         $journalData = new JournalData();
         $journalData->ThirdPartyRechargeIncomedocsFalse($incomedocsNo,$sysBankid,$rechargeAmount,CashJournalData::TYPE_Third_RECHARGE,CashJournalData::STATUS_APPLY,0,0,$date);

         //更新充值表
         $rechargeData->saveRechargeWhereTime($startTime,$endTime,RechargeData::STATUS_ARRIVAL,RechargeData::STATUS_ACCOUNTED_FOR,$date, $channelid);

         //更新入账
         $incomedocsData->saveStatus($incomedocsNo,PayIncomedocsData::STATUS_REFUSE,$userid,$date);

        DB::commit();
        $lk->unlock($key);
    }

    public function run(){
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
        
        $incomedocsData = new PayIncomedocsData();
        $channelData=new PayChannelData();
        $payData=new PayData();

        $model=$incomedocsData->newitem();
        $channels=$channelData->newitem()->get();
        foreach($channels as $channel)
        {
            $channelInfo=$channelData->get($channel->id);
            if($channelInfo->channel_infeecounttype!=self::TYPE_STEP)
            {
                $this ->ThirdPartyRechargeIncomedocs($start, $end, $channel->id);
            }
        }
        return true;
    }

    public function historyrun($start,$end){
        // $end = date("Y-m-d 00:00:00");
        // $start = date_create($end);
        // date_add($start, date_interval_create_from_date_string("-1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');

        $incomedocsData = new PayIncomedocsData();
        $channelData=new PayChannelData();
        $payData=new PayData();

        $model=$incomedocsData->newitem();
        $channels=$channelData->newitem()->get();
        // dump($channels);
        // return true;
        foreach($channels as $channel)
        {
            // dump($channel);
            $channelInfo=$channelData->get($channel->id);
            if($channelInfo->channel_infeecounttype!=self::TYPE_STEP)
            {
                // dump($channelInfo);
                // dump($channelInfo->channel_infeecounttype);
                $info=$model->where('income_starttime',$start)->where('income_endtime',$end)->where('income_3rdchannel',$channel->id)->first();
                if($info!=null)
                {
                    continue;
                }
                $this ->ThirdPartyRechargeIncomedocs($start, $end, $channel->id);
            }
        }
        return true;
    }
}
