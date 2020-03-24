<?php

namespace App\Http\Controllers\User;

use App\Data\User\BankAccountData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteUserBankAccount extends Controller
{
    protected $validateArray=[
        "bankCard"=>"required",
    ];

    protected $validateMsg = [
        "bankCard.required"=>"请输入银行卡号",
    ];

    /**
     * @api {post} user/deletecashbank 解绑银行卡
     * @apiName deletebankcard
     * @apiGroup bankcard
     * @apiVersion 0.0.1
     *
     * @apiParam {string} bankCard 银行卡号
     * @apiParam {string} paypwd 支付密码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      bankCard : '6814 **** 6418',
     *      paypwd  : '123qweASDF'
     *      
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : null
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $bankCard = $request['bankCard'];
        $data = new BankAccountData();
        $res = $data->delBank($bankCard);
        $this->Success();
    }
}
