<?php

namespace App\Http\Controllers\Kyc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Coin\CoinAddressInfoAdapter;
use App\Data\Coin\CoinAddressInfoData;

/**
 * 地址认证查询
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.8
 */
class GetCoinAddr extends Controller
{

    protected $validateArray=[
        "coinAddress"=>"required",
        "userName"=>"required",
    ];

    protected $validateMsg = [
        "coinAddress.required"=>"请输入钱包地址",
        "userName.required"=>"请输入身份证姓名",
    ];


    /**
     * @api {post} token/auth/getCoinAddr 查询用户地址认证信息
     * @apiName GetCoinAddr
     * @apiGroup kyc
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinAddress 钱包地址
     * @apiParam {string} userName 身份证姓名
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinAddress : "1234",
     *      userName    : "章三",
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
     *      data : {
     *          "coinAddress" : "1234",
     *          "userName"    : "章三",
     *          "userIdno"    : "42112************",
     *          "mobile"  : "132**********",
     *          "userEmail"   : "kaka@kaka.com",
     *          "status"      : {
     *              "no"   : "CAS00",
     *              "name" : "已提交",
     *          }
     *      }
     * }
     */
    public function run()
    {
        $request = $this->request->all();
        $addr = $this->request->input("coinAddress");
        $name = $this->request->input("userName");

        $coinAddrData = new CoinAddressInfoData;
        $coinAddrAdapter = new CoinAddressInfoAdapter;
        $coinAddr = $coinAddrData->getAddr($addr, $name);
        $info = $coinAddrAdapter->getDataContract($coinAddr);

        return $this->Success($info);
    }
}
