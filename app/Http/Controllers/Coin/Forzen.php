<?php

namespace App\Http\Controllers\Coin;

use App\Data\Coin\FrozenData;
use App\Data\User\CoinAccountData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinJournalData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Forzen extends Controller
{
    public function run()
    {
        $forzenData = new FrozenData();
        $res = $forzenData->RelieveForzen();

        $this->Success('解冻成功');
    }
}
