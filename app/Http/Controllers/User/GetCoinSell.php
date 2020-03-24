<?php

namespace App\Http\Controllers\User;

use App\Data\Trade\TranactionSellData;
use App\Data\Trade\TranactionOrderData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Project\ProjectGuidingPriceData;

class GetCoinSell extends Controller
{
    public function run()
    {
        $coinType = $this->request->input('coinType');

        //市场指导价
        $projectGuidingPriceData = new ProjectGuidingPriceData();
        $currentPrice = 0;
        $projectGuidingPrice = $projectGuidingPriceData->getGuidingPrice($coinType);
        if (!empty($projectGuidingPrice)) {
            $currentPrice = $projectGuidingPrice->project_guidingprice;
        }
        $res['price'] = $currentPrice;

        //成交
        $orderData = new TranactionOrderData();
        $res['order'] = $orderData->getSellInfo($coinType);

        //费率
        $res['fee'] = config("trans.withdrawalcoinfeerate");

        $this->Success($res);
    }
}
