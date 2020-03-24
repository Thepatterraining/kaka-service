<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Cash\UserRechargeData;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;

class GetPayUsers extends QueryController
{

    public function getData()
    {
        return new  PayUserData();
    }

    public function getAdapter()
    {
        return new PayUserAdapter();
    }

    protected function getItem($arr)
    {
        $userData = new \App\Data\User\UserData;
        $userAdapter = new \App\Http\Adapter\User\UserAdapter;
        $adminData = new \App\Data\Auth\UserData;
        $adminAdapter = new \App\Http\Adapter\Auth\UserAdapter;

        $user = $userData->get($arr['userid']);
        $arr['userid'] = $userAdapter->getDataContract($user);

        $payuser = $adminData->get($arr['payuser']);
        $arr['payuser'] = $adminAdapter->getDataContract($payuser);
        info($arr['checkuser']);
        $checkuser = $adminData->get($arr['checkuser']);
        $arr['checkuser'] = $adminAdapter->getDataContract($checkuser);

        return $arr;
    }
}
