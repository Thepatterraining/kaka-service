<?php

namespace App\Http\Controllers\Wechat;

use App\Data\Cash\BankAccountData;
use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Http\Adapter\Sys\CashBankAccountAdapter;
use App\Http\HttpLogic\BankLogic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetWithdrawalInfo extends Controller
{

    protected $validateArray=[
        "no"=>"required|exists:cash_withdrawal,cash_withdrawal_no|string",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入单据号!",
        "no.exists"=>"单据号不存在!",
        "no.string"=>"单据号必须是字符串!",
    ];

    //查找提现详细信息
    /**
     * @param no 提现单据号
     * @author zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new WithdrawalData();
        $adapter = new WithdrawalAdapter();
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

        return $this->Success($res);
    }
}
