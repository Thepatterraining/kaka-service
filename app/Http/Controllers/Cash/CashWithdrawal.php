<?php

namespace App\Http\Controllers\Cash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\Withdrawal\CashWithdrawalFac;

class CashWithdrawal extends Controller
{
    protected $validateArray=[
        "amount"=>"required",
        "bankid"=>"required",
        "bankNo"=>"required",
        "name"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入提现金额!",
        "bankid.required"=>"请输入银行卡号!",
        "bankNo.required"=>"请输入提现银行!",
        "name.required"=>"请输入提现人姓名!",
     
    ];

    /**
     * @api {post} cash/withdrawal 现金提现
     * @apiName CashWithdrawal
     * @apiGroup Cash
     * @apiversion 0.0.1
     *
     * @apiParam {string} bankid 提现银行卡号
     * @apiParam {number} amount 提现金额
     * @apiParam {number} bankNo 提现银行号
     * @apiParam {string} name 提现人姓名
     * @apiParam {string} paypwd 支付密码
     *
     * @apiParamExample {json} Request-Example:
     *
     *  {
     *      bankid : 1234123412341234,
     *      amount : 2000,
     *      bankNo : 2,
     *      name : 章三,
     *      paypwd : 1234qweASD
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : 'CW2017041118062373095'  提现单据号
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $amount = $request['amount'];
        $userBankId = $request['bankid'];
        $bankNo = $request['bankNo'];
        $name = $request['name'];
        
        $branchName = "默认支行";
        if (array_key_exists("branchName", $request)) {
            $branchName = $request['branchName'];
        }
        
        //提现操作
        $cashWithdrawalFac = new CashWithdrawalFac;
        $cashWithData = $cashWithdrawalFac->createCashWithData();
        $res = $cashWithData->withdrawal($amount, $userBankId, $bankNo, $name, $branchName);
        if ($res['success'] === false) {
            return $this->Error($res['code']);
        }

        $this->Success($res['success']);
    }
}
