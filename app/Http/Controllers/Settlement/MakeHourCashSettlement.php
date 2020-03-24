<?php

namespace App\Http\Controllers\Settlement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Settlement\CashSettlementData;

class MakeHourCashSettlement extends Controller
{
    //
    protected function run()
    {



        $fac = new CashSettlementData();

        $item = $fac->makeHourSettlement(1);
        if ($item!=false) {
            $this->Success($item);
        } else {
            $this->Error(808001);
        }
    }
}
