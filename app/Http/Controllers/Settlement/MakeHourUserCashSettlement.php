<?php

namespace App\Http\Controllers\Settlement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Settlement\UserCashSettlementData;

class MakeHourUserCashSettlement extends Controller
{

   
    protected function run()
    {



        $fac = new UserCashSettlementData();

        $item = $fac->makeAllUserHourSettlement();
        if ($item!=false) {
            $this->Success($item);
        } else {
            $this->Error(808001);
        }
    }
}
