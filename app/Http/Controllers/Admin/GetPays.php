<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayData;
use App\Http\Adapter\Pay\PayAdapter;

class GetPays extends QueryController
{

    public function getData()
    {
        return new  PayData();
    }

    public function getAdapter()
    {
        return new PayAdapter();
    }
}
