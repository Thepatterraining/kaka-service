<?php

namespace App\Http\Controllers\Cash;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\Withdrawal\CashWithdrawalFac;

class CashWithdrawalConfirm extends Controller
{
    protected $validateArray=[
        "confirm"=>"required|boolean",
        "no"=>"required|doc:withdrawal,CW00",
    ];

    protected $validateMsg = [
        "confirm.required"=>"请输入确认值!",
        "no.required"=>"请输入提现单据号!",
        "confirm.boolean"=>"确认值类型不正确!",
        "no.doc:withdrawal,CW00"=>"提现单据号不正确!",
    ];

    /**
     * 确认提现
     *
     * @param   confirm true and false
     * @param   no 提现单据号
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $withdrawalNo = $request['no'];
        $confirm = $request['confirm'];
        $desbankid = null;
        if (array_key_exists('desbankid', $request)) {
            $desbankid = $request['desbankid'];
        }

        //判断提现成功还是失败
        $cashWithdrawalFac = new CashWithdrawalFac;
        $cashWithData = $cashWithdrawalFac->createCashWithData();
        if ($confirm == true) {
            $res = $cashWithData->withdrawalTrue($withdrawalNo, $desbankid);
        } elseif ($confirm == false) {
            $res = $cashWithData->withdrawalFalse($withdrawalNo, $desbankid);
        }

        if ($res['success'] === false) {
            return $this->Error($res['code']);
        }
        $this->Success();
        
    }
}
