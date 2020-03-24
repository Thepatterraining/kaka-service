<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use App\Data\Activity\VoucherInfoData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use App\Http\Adapter\Activity\InfoAdapter;

class GetUserCoupons extends QueryController
{

    public function getData()
    {
        return new  VoucherStorageData();
    }

    public function getAdapter()
    {
        return new VoucherStorageAdapter();
    }

    protected function getItem($arr)
    {
        $userFac = new UserData();
        $userAdaper = new UserAdapter();
        $voucherData = new VoucherInfoData;
        $voucherAdapter  = new VoucherInfoAdapter;
        $activityData = new InfoData;
        $activityAdapter =  new InfoAdapter;
        $user = $userFac ->get($arr["userid"]);
            $arr["userid"]= $userAdaper->getDataContract($user);

            //查询代金券信息
            $voucher = $voucherData->getByNo($arr['voucherno']);
            $arr['voucherno'] = $voucherAdapter->getDataContract($voucher);

            //查询活动信息
            $activity = $activityData->getByNo($arr['activity']);
            $arr['activity'] = $activityAdapter->getDataContract($activity);
        return $arr;
    }
}
