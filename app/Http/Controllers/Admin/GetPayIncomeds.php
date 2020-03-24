<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;
use App\Data\Cash\UserRechargeData;
use App\Data\Payment\PayIncomedocsData;
use App\Http\Adapter\Pay\PayIncomedocsAdapter;

class GetPayIncomeds extends QueryController
{

    public function getData()
    {
        return new  PayIncomedocsData();
    }

    public function getAdapter()
    {
        return new PayIncomedocsAdapter();
    }
}
