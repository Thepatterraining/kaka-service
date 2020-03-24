<?php

namespace App\Data\Report;

use App\Data\IDataFactory;
use App\Data\Sys\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Sys\LockData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Schedule\IDaySchedule;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\Formater;
use App\Data\Report\ReportUserrbSubDayData;

class ReportUserrbSubDayInfoData extends IDataFactory//implements IDaySchedule
{

    /**
     * 用户查询邀请状态信息
     *
     * @param   pageSize 数量
     * @param   pageIndex 页码
     * @author  liu
     * @version 0.1
     */
    //修改属性 2017.9.14 liu
    protected $userAdapter = "App\Http\Adapter\Sys\UserAdapter";
    protected $userData = "App\Data\Sys\UserData";
    protected $reportAdapter = "App\Http\Adapter\Report\ReportUserrbSubDayInfoAdapter";
    // protected $noPre = "SCR";
    // protected $reportData="App\Data\Report\ReportUserrbSubDayData";
    protected $modelclass = "App\Model\Report\ReportUserrbSubDayInfo";
    protected $rechargeData="App\Data\Cash\RechargeData";
    protected $tranactionData="App\Data\Trade\TranactionOrderData";
    protected $invitationData="App\Data\Activity\InvitationData";
    protected $rakeBackTypeData="App\Data\Sys\RakebackTypeData";
    protected $rebateData="App\Data\Sys\RebateData";

    public function handle($array)
    {
        // $end=date("Y-m-d");
        // $start=date("Y-m-d",strtotime("-1 day"));
        // $end=date("2017-6-7");
        // $start=date("2017-6-6");

        // $endd = date_format(date_create($end), 'Y-m-d H:i:s');

        $reportAdapter=new $this->reportAdapter();
        $invitationData=new $this->invitationData();
        $userData=new $this->userData();
        $tranactionData=new $this->tranactionData();
        $rakeBackTypeData=new $this->rakeBackTypeData();
        // $reportUserrbSubData=new ReportUserrbSubData();

        // $lk = new LockData();

        if(!empty($array)) {
            foreach($array as $value)
            {
                // $res=array();
                // dump($value);
                $userId=$invitationData->getInvUser($value)->inviitation_user; 
                // dump($userId);
                // return true;
                $userInfo=$userData->get($userId);
                $userName=$userInfo->user_name;
                $userMobile=$userInfo->user_mobile;

                // $userRbbuyInfo=$reportUserrbSubData->getByUser($userId);
                // $userRbbuyCount=$userRbbuyInfo->report_rbascinv;
                // $userRbbuyCash=$userRbbuyInfo->report_rbbuy_asc;

                // $res['userid']=$userId;
                // $res['username']=$userName;
                // $res['usermobile']=$userMobile;
                // $res['userrbbuycount']=$userRbbuyCount;
                // $res['userrbbuycash']=$userRbbuyCash;

                $invUsersInfo=$invitationData->getInvRegUser($value);   
                if(!$invUsersInfo->isEmpty()) {
                    foreach($invUsersInfo as $invUser)
                    {

                        // $lockKey = get_class($this);

                        $invUserId=$invUser->inviitation_reguser;

                        $reportfilter =[
                            "filters"=>[
                            // "start"=>$startd,
                            // "end"=>$endd,
                            "userid"=>$userId,
                            "invuserid"=>$invUserId,
                            ]
                        ];
                        $queryfilter = $reportAdapter->getFilers($reportfilter);
                                
                        $items = $this->query($queryfilter, 1, 1);
                        // dump($items);
                        //dump($items["totalSize"]);
                        if ($items["totalSize"]==0) {
                            $resModel = $this->newitem();
                            $res=array();
                            $res['userid']=$userId;
                            $res['username']=$userName;
                            $res['usermobile']=$userMobile;
                            // $rpt["no"] = DocNoMaker::Generate($this->noPre);
                            // $res["start"] = $startd;
                            // $res["end"] = $endd;
                            // $rpt["accountid"] = $accountid;
                            $reportAdapter->saveToModel(false, $res, $resModel);
                            $this->create($resModel);
                            $res = $reportAdapter->getDataContract($resModel, null, true);
                        }
                        else
                        {
                            $model = $this->newitem();
                            $res=array();
                            $resModel=$model->where('report_user', $userId)->where('report_invuser_id', $invUserId)->first();
                            $res=$reportAdapter->getFromModel($resModel, true);
                            // dump($res);
                            // $resModel=$items;
                        }
                        // if ($lk->lock($lockKey)===false) {
                        //     continue ;
                        // }
                        // return true;
 
                        $invUserInfo=$userData->get($invUserId);
                        $invUserName=$invUserInfo->user_name;
                        $invUserMobile=$invUserInfo->user_mobile;

                        $rbbuyInfo=$tranactionData->getOrderByBuyUserId($invUserId);
                        $invUserRbbuyCount=count($rbbuyInfo);

                        $rbbuyCash=$tranactionData->getOrderSumByBuyUserId($invUserId);
                        $invUserRbbuyCash=$rbbuyCash;

                        $res['invuserid']=$invUserId;
                        $res['invusername']=$invUserName;
                        $res['invusermobile']=$invUserMobile;
                        $res['invuserrbbuycount']=$invUserRbbuyCount;
                        $res['invuserrbbuycash']=$invUserRbbuyCash;
                        $res['invuserrbbuyreturncash']=$rakeBackTypeData->getUserBuyRakeBackDirect($res['invuserrbbuycash']);
                        // $res['start']=$start;
                        // $res['end']=$end;

                        $reportAdapter->saveToModel(false, $res, $resModel);
                        $this->save($resModel);
                        // $lk->unlock($lockKey);
                        // return true;
                        // dump($res);
                    }
                }
            }
        }
        return true; 
    }
}
