<?php
namespace App\Data\Cash;

use App\Data\Cash\BankAccountData;
use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use Illuminate\Support\Facades\DB;
use App\Data\Cash\JournalData;
use App\Data\Sys\CashData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Payment\PayChannelData;
use App\Mail\NotifyReport;
use App\Data\Notify\INotifyEmail;
use App\Data\Notify\INotifyDefault;
use Illuminate\Support\Facades\Mail;
use App\Data\Auth\AccessToken;
use App\Data\Sys\SendSmsData;
use iscms\AlismsSdk\TopClient;
use iscms\Alisms\SendsmsPusher;
use App\Data\User\UserData;
use App\Data\API\SMS\SmsVerifyFactory;

class RechargeData extends IDatafactory implements INotifyEmail//,INotifyDefault
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Cash\Recharge';

    protected $no = 'cash_recharge_no';

    const NO_PRIFIX = 'CR';


    

    const STATUS_APPLY = 'CR00';
    const STATUS_SUCCESS = 'CR01';
    const STATUS_ERROR = 'CR02';
    const STATUS_CONFIRMED = 'CR03';
    const STATUS_ACCOUNTED_FOR = 'CR04';
    const STATUS_ARRIVAL = 'CR05';

    const APPLY_TYPE = 'CRT01';
    const THIRDPAYMENT_TYPE = 'CRT02';

    private $body = '';
 

    /**
     * 充值操作 增加充值数据
     *
     * @param   $rechargeNo  充值单据号
     * @param   $amount 充值金额
     * @param   $phone 手机号
     * @param   $bankId 充值卡号
     * @param   $desbankId 充值到卡号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 充值单号在内部生成
     * @author  zhoutao
     * @date    2017.11.21
     */
    public function addRecharge($phone, $amount, $bankId, $desbankId, $date = null, $type = 'CRT01', $channelid = 3)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $docNo = new DocNoMaker();
        $rechargeNo = $docNo->Generate('CR');
        $model = $this->newitem();
        $model->cash_recharge_no = $rechargeNo;
        $model->cash_recharge_phone = $phone;
        $model->cash_recharge_amount = $amount;
        $model->cash_recharge_useramount = $amount;
        $model->cash_recharge_sysamount = $amount;
        $model->cash_recharge_status = 'CR00';
        $model->cash_recharge_userid = $this->session->userid;
        $model->cash_recharge_bankid = $bankId;
        $model->cash_recharge_time = $date;
        $model->cash_recharge_desbankid = $desbankId;
        $model->cash_recharge_type = $type;
        $model->cash_recharge_channel = $channelid;
        $this->create($model);
        return $rechargeNo;
    }

    /**
     * 确认充值时候 查询充值信息
     *
     * @param   $rechargeNo 充值单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getRecharge($rechargeNo)
    {
        $where['cash_recharge_no'] = $rechargeNo;
        return $this->find($where);
    }

    /**
     * 查询提交时间在一个时间段的充值数据
     *
     * @param   $startTime 开始时间
     * @param   $endTime 结束时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getRechargeWhereTime($startTime, $endTime, $status, $channelid)
    {
        $model = $this->newitem();
        $res = $model->whereBetween('cash_recharge_time', [$startTime,$endTime])->where('cash_recharge_status', $status)->where('cash_recharge_channel', $channelid)->sum('cash_recharge_amount');
        return $res;
    }

    /**
     * 修改这个时间段的状态
     *
     * @param   $startTime 开始时间
     * @param   $endTime 结束时间
     * @param   $status 状态
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function saveRechargeWhereTime($startTime, $endTime, $status, $whereStatus, $date,$channelid)
    {
        $model = $this->modelclass;
        $recharges = $model::whereBetween('cash_recharge_time', [$startTime,$endTime])->where('cash_recharge_status', $whereStatus)->where('cash_recharge_channel', $channelid)->get();
        foreach ($recharges as $recharge) {
            $this->saveRechargeNoSuccess($recharge->cash_recharge_no, $status, $date);
        }
    }

    public function saveRecharge($rechargeNo, $success, $userid, $date, $body = '')
    {
        $recharge = $this->getByNo($rechargeNo);
        if (!empty($recharge)) {
            $type = $recharge->cash_recharge_type;
            //默认失败
            $status = self::STATUS_ERROR;
            if ($success) {
                if ($type == self::APPLY_TYPE) {
                    //普通
                    $status = self::STATUS_SUCCESS;
                } else {
                    //第三方
                    $status = self::STATUS_CONFIRMED;
                }        
            }

            $recharge->cash_recharge_status = $status;
            $recharge->cash_recharge_chkuserid = $userid;
            $recharge->cash_recharge_chktime = $date;
            $recharge->cash_recharge_success = $success;
            $recharge->cash_recharge_body = $body;
            $this->save($recharge);
        }
    }

    /**
     * 更新充值表状态和审核人
     *
     * @param   $status 状态
     * @param   $body 描述
     * @param   $model model
     * @param   $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    // public function saveRecharge($model, $body, $status = 'CR01', $success = 1, $date = null)
    // {
    //     if ($date == null) {
    //         $date = date('Y-m-d H:i:s');
    //     }
    //     $model->cash_recharge_status = $status;
    //     $model->cash_recharge_chkuserid = $this->session->userid;
    //     $model->cash_recharge_chktime = $date;
    //     $model->cash_recharge_body = $body;
    //     $model->cash_recharge_success = $success;
    //     return $model->save();
    // }

    /**
     * 更新充值表状态和审核人
     *
     * @param   $status 状态
     * @param   $rechargeNo 充值单据号
     * @param   $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    private function saveRechargeNoSuccess($rechargeNo, $status = 'CR01', $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getByNo($rechargeNo);
        $model->cash_recharge_status = $status;
        $model->cash_recharge_chkuserid = $this->session->userid;
        $model->cash_recharge_chktime = $date;
        return $model->save();
    }

    /**
     * 更新充值表状态和审核人
     *
     * @param   $status 状态
     * @param   $rechargeNo 充值单据号
     * @param   $success 是否成功
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    private function saveRechargeTrue($rechargeNo, $status = 'CR01', $success = 1, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getByNo($rechargeNo);
        $model->cash_recharge_status = $status;
        $model->cash_recharge_chkuserid = $this->session->userid;
        $model->cash_recharge_chktime = $date;
        $model->cash_recharge_success = $success;
        return $model->save();
    }

    /**
     * whereIn查找
     *
     * @param   $in 条件
     * @param   $pageSize
     * @param   $pageIndex
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.5
     */
    public function WhereIn($in, $pageSize, $pageIndex)
    {
        $model = $this->newitem();
        $res = [];
        $tmp = null;
        if (is_array($in)) {
            foreach ($in as $col => $val) {
                if (is_array($val)) {
                    if ($tmp == null) {
                        $tmp = $model->whereIn($col, $val);
                    } else {
                        $tmp = $tmp->whereIn($col, $val);
                    }
                } else {
                    if ($tmp == null) {
                        $tmp = $model->where($col, $val);
                    } else {
                        $tmp = $tmp->where($col, $val);
                    }
                }
            }
        }
        $res['totalSize'] = $tmp->count();
        $res['items'] = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->orderBy('cash_recharge_time', 'desc')->get();
        $res["pageIndex"]=$pageIndex;
        $res["pageSize"]=$pageSize;
        $res["pageCount"]= ($res['totalSize']-$res['totalSize']%$res["pageSize"])/$res["pageSize"] +($res['totalSize']%$res["pageSize"]===0?0:1);
        return $res;
    }




    /**
     * 查询提交时间在一个时间段的充值数据列表
     *
     * @param   $startTime 开始时间
     * @param   $endTime 结束时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getEachRechargeWhereTime($startTime,$endTime,$status,$channelid)
    {
        $model = $this->newitem();
        $res = $model->whereBetween('cash_recharge_time', [$startTime,$endTime])->where('cash_recharge_status', $status)->where('cash_recharge_channel', $channelid)->pluck('cash_recharge_amount');
        return $res;
    }

    /**
     * 查询用户的充值总金额
     *
     * @param   $userId 用户id　
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getRechargeCount($userId)
    {
        $model = $this->newitem();
        // $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        $success=1;
        // foreach($dicArray as $status)
        // {
            $where['cash_recharge_success']=$success;
            $res = $res+$model->where($where)->where('cash_recharge_userid', $userId)->sum('cash_recharge_amount');
        // }
        return $res;
    }
    /**
     * 查询一段时间内用户的充值总金额
     *
     * @param   $userId 用户id　
     * @param   $start  开始时间
     * @param   $end    结束时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getRechargeCountDaily($userId,$start,$end)
    {
        $model = $this->newitem();
        $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        // foreach($dicArray as $status)
        // {
            $success=1;
            $result=0;
            $where['cash_recharge_success']=$success;
            $rsp = $model->wherebetween('updated_at', [$start,$end])
                ->where($where)
                ->where('cash_recharge_userid', $userId)
                ->get();//->sum('cash_recharge_amount');
        foreach($rsp as $value){
            $result=$result + floor($value->order_cash * 100)/100;
        }  
            $res= $res+$result;     
        // }
        $result=floor($res * 100)/100;
        return $result;
    }

    /**
     * 查询一段时间内用户的充值总金额(不抹零)
     *
     * @param   $userId 用户id　
     * @param   $start  开始时间
     * @param   $end    结束时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getRechargeTrueCountDaily($userId,$start,$end)
    {
        $model = $this->newitem();
        $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        // foreach($dicArray as $status)
        // {
            $success=1;
            $result=0;
            $where['cash_recharge_success']=$success;
            $result = $model->wherebetween('updated_at', [$start,$end])
                ->where($where)
                ->where('cash_recharge_userid', $userId)
                ->sum('cash_recharge_amount');
        return $result;
    }


    /**
     * 查询一段时间内用户的充值总笔数 
     *
     * @param   $userId 用户id　
     * @param   $start  开始时间
     * @param   $end    结束时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getRechargeAmountDetailDaily($userId,$start,$end)
    {
        $model = $this->newitem();
        $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        $success=1;
        $result=0;
        $where['cash_recharge_success']=$success;
        $rsp = $model->wherebetween('updated_at', [$start,$end])
            ->where($where)
            ->where('cash_recharge_userid', $userId)
            ->get()->count();
        return $rsp;
    }

    public function getRechargeDay($userId,$channelid)
    {

        $start = date("Y-m-d 00:00:00");
        $end = date_create($start);
        date_add($end, date_interval_create_from_date_string("1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');      
        $end = date_format($end, 'Y-m-d H:i:s');
        $model = $this->newitem();
        $where['cash_recharge_success']=$success;
        $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        $rsp = $model->wherebetween('updated_at', [$start,$end])
            ->where($where)     
            ->where('cash_recharge_channel', $channelid)
            ->get();//->sum('cash_recharge_amount');
        foreach($rsp as $value){
                $result=$result + floor($value->order_cash * 100)/100;
        }  
            $res= $res+$result;     
       
        $result=floor($res * 100)/100;
        return $result;
    }

    /**
     * 查询一段时间内用户的充值总金额
     *
     * @param   $userId 用户id　
     * @param   $start  开始时间
     * @param   $end    结束时间
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getRechargeFeeDaily($userId,$start,$end)
    {
        $model = $this->newitem();
        $dicArray=['CR01','CR03','CR04','CR05'];//状态数组
        $res=0;
        // foreach($dicArray as $status)
        // {
            $success=1;
            $result=0;
            $where['cash_recharge_success']=$success;
            $rsp = $model->wherebetween('updated_at', [$start,$end])
                ->where($where)
                ->where('cash_recharge_userid', $userId)
                ->get();//->sum('cash_recharge_amount');
        foreach($rsp as $value){
            $result=$result + floor($value->order_cash * 100)/100;
        }  
            $res= $res+$result;     
        // }
        $result=floor($res * 100)/100;
        return $result;
    }

    /**
     * 查询一段时间内充值数量
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getUserRechargeCountDaily($start,$end)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $total = $model->whereBetween('created_at', [$start,$end])
            ->where($where)
            ->count();
        return $total;
    }

    /**
     * 查询一段时间内充值总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getCashCountDaily($start,$end)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $total = $model->whereBetween('created_at', [$start,$end])
            ->where($where)
            ->sum('cash_recharge_amount');
        return $total;
    }

    /**
     * 查询一段时间内线下充值总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getOfflineCashCountDaily($start,$end)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $payChannelData=new PayChannelData();
        $channels=$payChannelData->newitem()->where('channel_infeetype', 'FR00')->get();
        $total=0;
        if(!$channels->isEmpty()) {
            foreach($channels as $channel)
            {
                $total += $model->whereBetween('created_at', [$start,$end])
                    ->where($where)->where('cash_recharge_channel', $channel->id)
                    ->sum('cash_recharge_amount');
            }
        }
        return $total;
    }

    /**
     * 查询一段时间内三方充值总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getThirdCashCountDaily($start,$end)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $payChannelData=new PayChannelData();
        $channels=$payChannelData->newitem()->where('channel_infeetype', 'FR01')->get();
        $total=0;
        if(!$channels->isEmpty()) {
            foreach($channels as $channel)
            {
                $total += $model->whereBetween('created_at', [$start,$end])
                    ->where($where)->where('cash_recharge_channel', $channel->id)
                    ->sum('cash_recharge_amount');
            }
        }
        return $total;
    }

    /**
     * 查询一段时间内充值成功人次
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getInvCountDaily($start,$end)
    {
        $model = $this->newitem();
        // $success=1;
        // $where['cash_recharge_success']=$success;
        // $total = $model
        //                 ->whereBetween('created_at',[$start,$end])
        //                 ->where($where)
        //                 ->select(DB::raw('distinct cash_recharge_userid'))
        //                 ->count();
        $total = DB::select('select count(distinct cash_recharge_userid) as count from cash_recharge where cash_recharge_success = 1 and created_at between ? and ?', [$start,$end]);
        return $total;
    }

    /**
     * 查询一段时间内指定渠道充值数量
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @param  $type 类型
     * @author liu
     */
    public function getRechargeItemCountDaily($start,$end,$type)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $where['cash_recharge_channel']=$type;
        $total = $model->whereBetween('created_at', [$start,$end])
            ->where($where)
            ->count();
        return $total;
    }

    /**
     * 查询一段时间内指定渠道充值总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @param  $type 类型
     * @author liu
     */
    public function getRechargeItemCashCountDaily($start,$end,$type)
    {
        $model = $this->newitem();
        $success=1;
        $where['cash_recharge_success']=$success;
        $where['cash_recharge_channel']=$type;
        $total = $model->whereBetween('created_at', [$start,$end])
            ->where($where)
            ->sum('cash_recharge_amount');
        return $total;
    }

    /**
     * 查询一段时间内指定渠道充值成功人次
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @param  $type 类型
     * @author liu
     */
    public function getRechargeItemInvCountDaily($start,$end,$type)
    {
        $model = $this->newitem();
        // $success=1;
        // $where['cash_recharge_success']=$success;
        // $where['cash_recharge_channel']=$type;
        $total = DB::select('select count(distinct cash_recharge_userid) as count from cash_recharge where cash_recharge_success = 1 and cash_recharge_channel = ? and created_at between ? and ?', [$type,$start,$end]);
        return $total;
        // $total = $model->select(DB::raw('distinct cash_recharge_userid'))
        //                 ->whereBetween('created_at',[$start,$end])
        //                 ->where($where)
        //                 ->count();
        // return $total;
    }

    public function getRechargeDaily($start,$end)
    {
        $model = $this->newitem();
        $success=1;
        $result=0;
        $where['cash_recharge_success']=$success;
        $rsp = $model->wherebetween('created_at', [$start,$end])
            ->where($where)
            ->get();
        return $rsp;
    }

    /**
     * 更新第三方充值单号
     *
     * @param $rechargeNo 充值单号
     * @param $thirdNo 第三方单号
     */
    public function saveThirdNo($rechargeNo, $thirdNo)
    {
        $recharge = $this->getByNo($rechargeNo);
        $recharge->cash_recharge_thirdplatdocno = $thirdNo;
        $this->save($recharge);
    }

    /**
     * 更新用户手机号
     *
     * @param $rechargeNo 充值单号
     * @param $mobile 手机号
     */
    public function saveMobile($rechargeNo, $mobile)
    {
        $recharge = $this->getByNo($rechargeNo);
        $recharge->cash_recharge_phone = $mobile;
        $this->save($recharge);
    }

    /**
     * 更新银行卡号
     */
    public function saveBankCard($rechargeNo, $bankCard)
    {
        $recharge = $this->getByNo($rechargeNo);
        $recharge->cash_recharge_bankid = $bankCard;
        $this->save($recharge);
    }
    
    public function notifyemailrun($address,$name,$notifyName,$attach)
    {
        Mail::to([$address])->send(new NotifyReport($address, $name, $notifyName, $attach));
        return true;
    }

    // public function notifycreateddefaultrun($data){

    // public function notifysaveddefaultrun($data){
    //     $sendSmsData=new SendSmsData();
    //     $userData=new UserData();
    //     $cashAccountData=new CashAccountData();

    //     $userId=$data['cash_recharge_userid'];
    //     $phone=$data['cash_recharge_phone'];
    //     $userInfo=$userData->get($userId);
    //     if(!$userInfo->user_name)   
    //     {
    //         $name="用户";
    //     }
    //     else
    //     {
    //         $name=$userInfo->user_name;
    //     }
    //     $money=$data['cash_recharge_useramount'];
    //     $user=$cashAccountData->getitem()->where('account_userid',$userId)->account_cash;
    //     $no=$data["cash_recharge_no"];

    //     $smsVerifyFac=new SmsVerifyFactory();
    //     $verify = $smsVerifyFac->CreateVerify();
    //     $verify->SendRechargeNotify($phone, $no, $userName, $money, $user);
    //     return true;
    // }

    // public function notifydeleteddefaultrun($data){

    // }
}

