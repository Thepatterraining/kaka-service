<?php

namespace App\Http\Controllers\Kyc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Coin\CoinAddressInfoAdapter;
use App\Data\Coin\CoinAddressInfoData;
use App\Data\Sys\LockData;
use App\Data\Coin\CoinTransferLogData;

/**
 * 修改用户地址状态
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.7
 */
class SaveCoinAddr extends Controller
{

    protected $validateArray=[
        "address"=>"required|doc:coinAddress,CAS01,CAS04",
        "count"=>"required",
    ];

    protected $validateMsg = [
        "address.required"=>"请输入钱包地址",
        "count.required"=>"请输入数量",
    ];


    /**
     * @api {post} token/auth/saveCoinAddr 修改用户地址状态
     * @apiName saveCoinAddr
     * @apiGroup kyc
     * @apiVersion 0.0.1
     *
     * @apiParam {string} count 数量
     * @apiParam {string} address 钱包地址
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      address : 1234,
     *      count   : 1234,
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : null
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $count = $this->request->input("count");
        $address = $this->request->input("address");

        $coinTransferLogData = new CoinTransferLogData;
        $coinTransferLogData->check($address, $count);
        return $this->Success();
    }
}
