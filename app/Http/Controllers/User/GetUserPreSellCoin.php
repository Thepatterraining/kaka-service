<?php

namespace App\Http\Controllers\User;

use App\Data\Coin\FrozenData;
use App\Data\Item\FormulaData;
use App\Data\Project\ProjectData;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CoinAccountData;
use App\Http\Adapter\Coin\FrozenAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserTypeData;
use App\Data\Sys\ErrorData;
use App\Data\Trade\TranactionSellData;
use App\Data\Utils\Formater;

class GetUserPreSellCoin extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型",
    ];

    /**
     * @api {post} login/user/getuserpresellcoin 准备卖出时候获取信息
     * @apiName getuserpresellcoin
     * @apiGroup Coin
     * @apiVersion 0.0.1
     *
     * @apiParam {string} accessToken token
     * @apiParam {string} coinType 代币类型
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      accessToken : token
     *      coinType : 'KKC-BJ0001'
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
     *      data : {
     *              "feeRate" : 0.00270, //费率
     *              "startInterval" : 1280, //可交易区间 开始
     *              "endInterval" : 1733, //可交易区间 结束
     *              "highestOrderPrice" : 190513.000 //历史最高成交价
     *              "currentPrice" : 659.000 //最低卖出价
     *          }
     *  }
     */
    public function run()
    {
        //获取项目id
        $coinType = $this->request->input('coinType');

        $data = new CoinAccountData();

        //解冻
        $forzenData = new FrozenData();
        $forzenAdapter = new FrozenAdapter();
        $forzenData->RelieveForzen();

        //查询可交易区间
        $projectData = new ProjectData;
        $interval = $projectData->getInterval($coinType);

        //查询费率
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        if ($data->isPrimary($coinType) === true) {
            $feeRate = $sysConfigs[UserTypeData::MARKET_CASH_SELL_FEE_RATE];
        } else {
            $feeRate = $sysConfigs[UserTypeData::$CASH_SELL_FEE_RATE];
        }

        //获取历史最高成交价
        $orderData = new TranactionOrderData;
        $highestOrderPrice = $orderData->getHighestOrderPrice($coinType);

        //获取最低卖单价
        $sellData = new TranactionSellData;
        $currentPrice = $sellData->getCurrentPrice($coinType);
        
        $res = [];
        $res['feeRate'] = floatval($feeRate);
        $res['startInterval'] = $interval['start'];
        $res['endInterval'] = $interval['end'];
        $res['highestOrderPrice'] = Formater::ceil($highestOrderPrice, 2);
        $res['currentPrice'] = Formater::ceil($currentPrice, 2);

        return $this->Success($res);
    }
}
