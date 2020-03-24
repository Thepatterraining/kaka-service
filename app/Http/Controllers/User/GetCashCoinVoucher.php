<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\VoucherStorageData;
use App\Data\Coin\FrozenData;
use App\Data\Trade\TranactionSellData;
use App\Data\User\CashAccountData;
use App\Data\User\CoinAccountData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetCashCoinVoucher extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
        "sellNo"=>"required"
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型!",
        "sellNo.required"=>"请输入卖单号!",
    ];

    /**
     * 卖单列表查询余额和现金券
     *
     * @param   coinType 代币类型
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $coinType = $this->request->input('coinType');

        $sellNo = $this->request->input('sellNo');

        //现金余额
        $cashData = new CashAccountData();
        $res['cash'] = $cashData->getCash();
        $res['cash'] = sprintf("%.2f", $res['cash']);

        //解冻
        $forzenData = new FrozenData();
        $forzenData->RelieveForzen();

        //代币余额
        $coinData = new CoinAccountData();
        $res['coin'] = $coinData->getUserCoinCash($coinType);

        //手续费率
        $res['coinFee'] = config("trans.withdrawalcoinfeerate");

        //现金券
        $res['voucher'] = [];

        //查询卖单
        $sellData = new TranactionSellData();
        $primary = $sellData->isPrimary($sellNo);

        if ($primary === true) {
            $voucherData = new VoucherStorageData();
            $res['voucher'] = $voucherData->getList();
        }

        $this->Success($res);
    }
}
