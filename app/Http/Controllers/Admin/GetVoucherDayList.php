<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetVoucherDayList extends QueryController
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
        $date=date_format(date_create($arr['voucherstorege_usetime']), "Y-m-d");
        if($date==date('Y-m-d')) {
            return $arr;
        }
        else
        {
            return null;
        }
        // $arr['item'] = $itemData->getInfo($arr['cointype']);
        //     $arr['order'] = $orderData->getInfo($arr['cointype']);

        //     $user = $userFac ->get($arr["userid"]);
        //     $arr["userid"]= $userAdaper->getDataContract($user);
        //     return $arr;
    }
}
