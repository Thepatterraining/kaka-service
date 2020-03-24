<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Cash\UserRechargeData;
use App\Data\Activity\InvitationCodeData;
use App\Http\Adapter\Activity\InvitationCodeAdapter;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Activity\InfoData;
use App\Http\Adapter\Activity\InfoAdapter;

class GetInvitionCodes extends QueryController
{
    public function getData()
    {
        return new  InvitationCodeData();
    }

    public function getAdapter()
    {
        return new InvitationCodeAdapter();
    }

    protected function getItem($arr)
    {
        $userData = new UserData();
        $userAdp = new UserAdapter();
        $activityInfoData = new InfoData();
        $activityInfoAdapter = new InfoAdapter();
        $userArray = ["loginid","name","idno","mobile"];
        if ($arr["userid"]) {
                    $useritem = $userData->get($arr["userid"]);
                    $userarr = $userAdp->getDataContract($useritem, $userArray, true);
                    $arr["userid"] = $userarr;
        }

        if ($arr["activityno"]) {
            $activityitem = $activityInfoData->getByNo($arr["activityno"]);
            $activityarr = $activityInfoAdapter->getDataContract($activityitem);
            $arr["activityno"] = $activityarr;
        }
        return $arr;
    }
}

