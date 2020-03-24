<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\RechargeData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Report\ReportUserrbSubDayData;
use Illuminate\Support\Facades\DB;

class InvitationData extends IDatafactory
{

    protected $no = 'inviitation_no';
    protected $modelclass = 'App\Model\Activity\Invitation';

    /**
     * 添加邀请记录
     *
     * @param   $code 邀请码
     * @param   $codeUserId 邀请人userid
     * @param   $userId 受邀请人 userid
     * @param   string                     $type 类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function add($code, $codeUserId, $userId, $type = 'INV01')
    {
        $doc = new DocNoMaker();
        $no = $doc->Generate('INV');
        $model = $this->newitem();
        $model->inviitation_no = $no;
        $model->inviitation_code = $code;
        $model->inviitation_user = $codeUserId;
        $model->inviitation_reguser = $userId;
        $model->inviitation_type = $type;
        return $this->create($model);
    }

    /**
     * 根据用户使用过哪些邀请码
     *
     * @param   $userid 用户
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserInvitations($userid)
    {
        $where['inviitation_reguser'] = $userid;
        $model = $this->modelclass;
        $userInvitations = $model::where($where)->get();
        return $userInvitations;
    }

    /**
     * 根据邀请码得到用户id
     *
     * @param   $invCode 邀请码
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserInvCode($invCode)
    {
        $where['inviitation_code'] = $invCode;
        $model = $this->modelclass;
        $userId = $model::where($where)->pluck('inviitation_reguser');
        return $userId;
    }

    /**
     * 根据邀请码得到一天受邀用户id
     *
     * @param   $invCode 邀请码
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserInvCodeDaily($invCode,$start,$end)
    {
        $where['inviitation_code'] = $invCode;
        $model = $this->modelclass;
        $userId = $model::wherebetween('created_at', [$start,$end])->where($where)->pluck('inviitation_reguser');
        return $userId;
    }

    /**
     * 得到一天累计邀请金额
     *
     * @author  liu
     * @version 0.1
     */
    public function getUserInvitationAmount()
    {
        $tranactionOrderData=new TranactionOrderData();
        $rakebackTypeData=new RakebackTypeData();
        $tranactionOrderModel=$tranactionOrderData->newitem();
        $rakebackTypeData=new RakebackTypeData();

        $userId=$this->session->userid;
        // $userId=3018;
        // $where['inviitation_user'] = $userId;
        // $model = $this->modelclass;
        // $info = $model::where($where)->get();
        // $result=0;
        // if(!$info->isEmpty())
        // {
        //     foreach($info as $value)
        //     {
        //         $result=$result+$tranactionOrderModel->where('order_buy_userid',$value->inviitation_reguser)
        //         ->sum('order_cash');
        //     }
        // }
        // $result=$rakebackTypeData->getUserBuyRakeBack($result);
        $reportUserrbSubDayData=new ReportUserrbSubDayData();
        $result=$reportUserrbSubDayData->getRebuyDaily($userId);
        // $result=$rakebackTypeData->getUserBuyRakeBack($result);     
        return $result;
    }
    
    public function getInvStatus($regUser)
    {
        $model=$this->newitem();
        $result=$model->where('inviitation_reguser', $regUser)->first();
        return $result;
    }

    public function getTotalBuy($start,$end)
    {
        // $model=$this->modelclass();
        $result=DB::select(
            "select count(A.order_buy_userid) amount,sum(total) cash,inviitation_user 
        from 
        activity_invitation 
        join
        (select sum(order_cash) total ,order_buy_userid 
        from transaction_order where created_at>=? and created_at<=?
        group by order_buy_userid )A on 
        activity_invitation.inviitation_reguser = A.order_buy_userid where A.order_buy_userid!=0 group by inviitation_user", [$start,$end]
        );
        return $result;
    }

    public function getTotalRecharge($start,$end)
    {
        // $model=$this->modelclass();
        $result=DB::select(
            "select count(A.cash_recharge_userid) amount,sum(total) cash,inviitation_user 
        from 
        activity_invitation 
        join
        (select sum(cash_recharge_amount) total ,cash_recharge_userid 
        from cash_recharge where created_at>=? and created_at<=?
        group by cash_recharge_userid )A on 
        activity_invitation.inviitation_reguser = A.cash_recharge_userid where A.cash_recharge_userid!=0 group by inviitation_user", [$start,$end]
        );
        return $result;
    }

    public function getInvRegUser($code)
    {
        $model=$this->newitem();
        $result=$model->where('inviitation_code', $code)->get();
        return $result;
    }

    public function getInvUser($code)
    {
        $model=$this->newitem();
        $result=$model->where('inviitation_code', $code)->first();
        return $result;
    }
}
