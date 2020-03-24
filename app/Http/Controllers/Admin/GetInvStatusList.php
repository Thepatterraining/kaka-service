<?php

namespace App\Http\Controllers\Admin;

use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Http\Adapter\User\CashAccountAdapter;

class GetInvStatusList extends QueryController
{

    public function getData()
    {
        return  new UserData();
    }

    public function getAdapter()
    {
        return new UserAdapter();
    }

    protected function getItem($arr)
    {
        $invitationData=new InvitationData();
        $rechargeData=new RechargeData();
        $invPersonId = $invitationData->getUserInvCode($arr['invcode']);
            //var_dump($invPersonId);
            $sum=count($invPersonId);
            $count=0;
        foreach($invPersonId as $userId){
            $count=$count+$rechargeData->getRechargeCount($userId);
        }
            $arr['invStatus']['userInvCode'] = $sum;
            $arr['invStatus']['userInvCount'] = $count;
        return $arr;
    }

}
