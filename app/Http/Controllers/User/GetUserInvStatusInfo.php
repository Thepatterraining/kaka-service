<?php

namespace App\Http\Controllers\User;

use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Trade\TranactionOrderData;

class GetUserInvStatusInfo extends Controller
{
    protected $validateArray=[

    ];

    protected $validateMsg = [

    ];

    /**
     * 用户查询邀请状态信息
     *
     * @param   pageSize 数量
     * @param   pageIndex 页码
     * @author  liu
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new UserData();
        $adapter = new UserAdapter();
        $invitationData=new InvitationData();
        $rechargeData=new RechargeData();
        $tranactionOrderData=new TranactionOrderData();

        // $userInfo=$data->get(1);
        $userInfo=$data->get($this->session->userid);
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);
        //var_dump($invPersonId);
        $sum=count($invPersonId);
        $count=0;
        $tradeCount=0;

        foreach($invPersonId as $id){
            $count=$count+$rechargeData->getRechargeCount($id);
            $tradeCount=$tradeCount+$tranactionOrderData->getOrderSumByBuyUserId($id);
        }
        $res['invStatus']['userInvCode'] = $sum;
        $res['invStatus']['userInvCount'] = $count;
        $res['invStatus']['userInvTradeCount']=$tradeCount;

        return $this->Success($res);
    }
}
