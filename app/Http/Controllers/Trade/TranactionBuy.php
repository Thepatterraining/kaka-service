<?php

namespace App\Http\Controllers\Trade;

use App\Data\Sys\ErrorData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Data\Rank\OrderList;
use App\Data\Project\ProjectData;

class TranactionBuy extends Controller
{
    protected $validateArray=[
        "count"=>"required|numeric|min:1",
        "price"=>"required|numeric",
        "coinType"=>"required",
        // "voucherNo"=>"required",
    ];

    protected $validateMsg = [
        "count.required"=>"请输入买单数量!",
        "price.required"=>"请输入买单单价!",
        "count.numeric"=>"购买数量请输入数字!",
        "price.numeric"=>"购买单价请输入数字!",
        "coinType.required"=>"请输入代币类型!",
        "voucherNo.required"=>"请输入现金券编号!",
        "count.min"=>"最小买入1份!",
    ];

    /**
     * @api {post} login/trade/transbuy 挂二级市场买单
     * @apiName transbuy
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型
     * @apiParam {string} count 买的数量
     * @apiParam {string} price 买的价格
     * @apiParam {string} paypwd 支付密码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinType : 'KKC-BJ0001',
     *      count    : 1,
     *      price    : 2000,
     *      paypwd   : 123qweA
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
     *      data : 'TS2017082111322789389' //买单号  
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $count = $request['count'];
        $price = $request['price'];
        $coin = $request['coinType'];
        $count = intval($count);
        // $voucherNo = $request['voucherNo'];

        //判断是一级市场返回错误
        $userCoinData = new CoinAccountData();
        if ($userCoinData->isPrimary($coin) === false) {
            return $this->Error(ErrorData::$LEVEL_ONE_NOT_BUY);
        }

        //判断交易区间
        $projectData = new ProjectData;
        if ($projectData->checkInterval($coin, $price) === false) {
            return $this->Error(ErrorData::PRICE_NOT_INTERVAL);
        }

        //声称流水单据号
        $docNo = new DocNoMaker();
        $transactionBuyNo = $docNo->Generate('TB');

        //执行挂买单业务
        $userCashBuyData = new UserCashBuyData(UserCashBuyData::GET_MARKET_FEE);
        $date = date('Y-m-d H:i:s');
        $userCashBuy = $userCashBuyData->addBuyOrder($transactionBuyNo, $count, $price, $coin, $date, '', TranactionBuyData::LEVEL_TYPE_MARKET);
        if ($userCashBuy === 806001) {
            return $this->Error(806001);
        } elseif ($userCashBuy === 806002) {
            return $this->Error(806002);
        }

        //加入买单队列
        $orderList = new OrderList($coin);
        $orderList->AddBuy($price, $count);

        //调用成交查看是否有可成交
        // $transactionOrderData = new TranactionOrderData();
        // $transactionOrderData->buySellOrder($transactionBuyNo, $date);

        //返回
        $this->Success($transactionBuyNo);
    }
}
