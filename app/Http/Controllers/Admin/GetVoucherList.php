<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\VoucherInfoData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetVoucherList extends QueryController
{

    public function getData()
    {
        return new  VoucherInfoData();
    }

    public function getAdapter()
    {
        return new VoucherInfoAdapter();
    }
}
