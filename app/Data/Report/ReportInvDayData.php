<?php

namespace App\Http\User\Report;

use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Transaction\TransactionData;

class ReportUserInvStatusInfoData extends IReportUserInvStatusInfoData
{

    /**
     * 用户查询邀请状态信息
     *
     * @param   pageSize 数量
     * @param   pageIndex 页码
     * @author  liu
     * @version 0.1
     */

    protected $userAdapter = "App\Http\Adapter\Sys\UserAdapter";
    protected $userData = "App\Data\Sys\UserData";
    protected $reportAdapter = "App\Http\Adapter\Report\ReportSumsDayAdapter";
    // protected $noPre = "SCR";
    protected $reportData="App\Data\Report\ReportSumsDayData";
    protected $modelclass = "App\Model\Report\ReportSumsDay";

    public function getPerson()
    {
        $data = new UserData();
        $adapter = new UserAdapter();
        $invitationData=new InvitationData();
        $rechargeData=new RechargeData();

        $userInfo=$data->get($this->session->userid);
        $userInvcode=$userInfo->user_invcode;
        $invPersonId = $invitationData->getUserInvCode($userInvcode);
        //var_dump($invPersonId);
        $sum=count($invPersonId);
        $count=0;
        $transactionCount=0;
        $transactionSum=0;

        foreach($invPersonId as $id){
            //if($id>=1&&$id<=100)
            //{
            $count=$count+$rechargeData->getRechargeCount($id);

            //}
        }
        $res['invStatus']['userInvCode'] = $sum;
        $res['invStatus']['userInvCount'] = $count;
        $res['invStatus']['userTransactionSum']=$transactionSum;
        $res['invStatus']['userTransactionCount']=$transactionCount;

        return $res;
    }
}
