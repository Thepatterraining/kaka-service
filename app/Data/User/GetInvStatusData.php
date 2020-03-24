<?php

namespace App\Http\Data\User;

use App\Data\IDataFactory;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Trade\TranactionOrderData;

class GetInvStatusData extends IDataFactory
{
    /**
     * 用户查询邀请状态信息
     *
     * @author  liu
     * @version 0.1
     */
    public function getInvDayInfo()
    {
        //$request = $this->request->all();
        $data = new UserData();
        $adapter = new UserAdapter();
        $invitationData=new InvitationData();
        $rechargeData=new RechargeData();
        $tranactionData=new TranactionOrderData();

        $start=date("Y-m-d 0:00:00");
        $lastStart=date_create($start);
        date_add($lastStart, date_interval_create_from_date_string("-1 days"));
        $lastStart = date_format($lastStart, 'Y-m-d H:i:s');
        $end=date_create($start);
        date_add($end, date_interval_create_from_date_string("1 days"));
        $end = date_format($end, 'Y-m-d H:i:s');
        $lastEnd=date_create($start);

        $userInfo=$data->get($this->session->userid);
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);

        //当天数据处理
        $invcodayPersonId = $invitationData->getUserInvCodeDaily($userInvcode, $start, $end);
        $sumToday=count($invcodayPersonId);
        $countToday=0;
        $tranactionCountToday=0;
        $tranactionSumToday=0;

        foreach($invPersonId as $id){
            $countToday=$countToday+$rechargeData->getRechargeCountDaily($id, $start, $end);
            $orderDailyToday=$tranactionData->getOrderSumByBuyUserIdDaily($id, $start, $end);
            foreach($orderDailyToday as $value)
            {
                $tranactionCountToday=$tranactionCountToday+$value->order_amount;   
            }
            $tranactionSumToday=$tranactionSumToday+count($orderDailyToday);       
        }
        $res['today']['user_invcode_today'] = $sumToday;
        $res['today']['user_invcount_today'] = $countToday;
        $res['today']['user_tranactionsum_today']=$tranactionSumToday;
        $res['today']['user_tranactioncount_today']=$tranactionCountToday;

        //前一天数据处理
        $invYesterdayPersonId = $invitationData->getUserInvCodeDaily($userInvcode, $lastStart, $lastEnd);
        $sumYesterday=count($invYesterdayPersonId);
        $countYesterday=0;
        $tranactionCountYesterday=0;
        $tranactionSumYesterday=0;

        foreach($invPersonId as $id){
            $countYesterday=$countYesterday+$rechargeData->getRechargeCountDaily($id, $lastStart, $lastEnd);
            $orderDailyYesterday=$tranactionData->getOrderSumByBuyUserIdDaily($id, $lastStart, $lastEnd);
            foreach($orderDailyYesterday as $value)
            {
                $tranactionCountYesterday=$tranactionCountYesterday+$value->order_amount;   
            }
            $tranactionSumYesterday=$tranactionSumYesterday+count($orderDailyYesterday);       
        }
        $res['yesterday']['user_invcode_yesterday'] = $sumYesterday;
        $res['yesterday']['user_invcount_yesterday'] = $countYesterday;
        $res['yesterday']['user_tranactionsum_yesterday']=$tranactionSumYesterday;
        $res['yesterday']['user_tranactioncount_yesterday']=$tranactionCountYesterday;

        return $res;
    }
}
