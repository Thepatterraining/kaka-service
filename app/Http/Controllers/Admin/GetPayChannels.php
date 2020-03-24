<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayChannelData;
use App\Http\Adapter\Pay\PayChannelAdapter;

class GetPayChannels extends QueryController
{

    public function getData()
    {
        return new  PayChannelData();
    }

    public function getAdapter()
    {
        return new PayChannelAdapter();
    }
}
