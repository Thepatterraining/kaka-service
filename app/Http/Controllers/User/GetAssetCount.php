<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\User\CoinAccountAdapter;

class GetAssetCount extends Controller
{

    /**
     * @api {post} user/getassetCount 获取项目估值
     * @apiName 获取项目估值
     * @apiGroup Coin
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : 'token'
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
     *      data : {
     *               "scale" => "0.01"   比例因子
     *               "valuation" => 0  估值
     *               "percentage" => 72.289156626506
     *               "name" => "德胜房产系列001号" 项目名称
     *               "count" => 3120 数量 平米
     *      }
     *  }
     */
    public function run()
    {
        $data = new CoinAccountData();
        $adapter = new CoinAccountAdapter();

        $assets = $data->getAssets();

        return $this->Success($assets);
    }
}
