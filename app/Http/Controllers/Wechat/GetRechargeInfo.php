<?php

namespace App\Http\Controllers\Wechat;

use App\Data\Cash\BankAccountData;
use App\Data\Cash\RechargeData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Http\Adapter\Sys\CashBankAccountAdapter;
use App\Http\HttpLogic\BankLogic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetRechargeInfo extends Controller
{
    protected $validateArray=[
        "no"=>"required|exists:cash_recharge,cash_recharge_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入充值单据号!",
        "no.exists"=>"充值单据号不存在!",
        "no.string"=>"充值单据号必须是字符串!",
    ];

    /**
     * 查询充值详细
     *
     * @param   $no 充值单据号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.20
     */
    public function run()
    {
        $data = new RechargeData();
        $adapter = new RechargeAdapter();
        $filersWhere['filters']['no'] = $this->request->input('no');
        $filers = $adapter->getFilers($filersWhere);
        $item = $data->find($filers);
        $res = $adapter->getDataContract($item);
        $datafac = new BankAccountData();
        $adapter = new CashBankAccountAdapter();
        $models = $datafac->query(array(), 10, 1);
        $bankfac = new BankLogic();

        foreach ($models["items"] as $model) {
            $itemtoadd = $adapter->getDataContract($model, ["no","name","bank"], true);
            $itemtoaddtwo = $bankfac->getBank($itemtoadd["bank"]);
            $res['bank'] = array_merge($itemtoadd, $itemtoaddtwo);
        }
        $this->Success($res);
    }
}
