<?php

namespace App\Http\Controllers\Trade;

use App\Data\Coin\FrozenData;
use App\Data\Project\ProjectData;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\User\CoinJournalData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Data\Rank\OrderList;

class TranactionSell extends Controller
{
    protected $validateArray=[
        "count"=>"numeric",
        "price"=>"required|numeric",
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "count.required"=>"请输入卖单数量!",
        "price.required"=>"请输入卖单单价!",
        "count.numeric"=>"卖出数量请输入数字!",
        "price.numeric"=>"卖出单价请输入数字!",
        "coinType.required"=>"请输入代币类型!",
        "count.min"=>"最小卖出1份!",
    ];

    /**
     * @api {post} login/trade/transsell 挂二级市场卖单
     * @apiName transsell
     * @apiGroup Trade
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型
     * @apiParam {string} count 卖的数量
     * @apiParam {string} price 卖的价格
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
     *      data : {
     *              cash        : 0, //'剩余代币'
     *              pending     : 0, //'剩余在途代币'
     *              no          : 'TS2017082111322789389', //卖单号
     *      }   
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $price = $request['price'];
        $coin = $request['coinType'];
        $count = 0;
        if ($this->request->has('count')) {
            $count = $request['count'];
        }
        $count = intval($count);

        //声称流水单据号
        $docNo = new DocNoMaker();
        $userCoinJournalNo = $docNo->Generate('UOJ');
        $transactionSellNo = $docNo->Generate('TS');

        //判断交易区间
        $projectData = new ProjectData;
        if ($projectData->checkInterval($coin, $price) === false) {
            return $this->Error(ErrorData::PRICE_NOT_INTERVAL);
        }

        //解冻
        $forzenData = new FrozenData();
        $forzenData->RelieveForzen();

        //执行挂卖单业务
        $coinSellData = new CoinSellData();
        $date = date('Y-m-d H:i:s');
        $res = $coinSellData->marketSell($count, $price, $coin, $userCoinJournalNo, $transactionSellNo, $date);
        if (is_int($res)) {
            return $this->Error($res);
        }

        //加入买单队列
        // $orderList = new OrderList($coin);
        // $orderList->AddSell($price, $count);

        //调用成交查看是否有可成交
        // $transactionOrderData = new TranactionOrderData();
        // $transactionOrderData->sellOrder($transactionSellNo, $date);
        
        $res = [];
        $res['no'] = $transactionSellNo;
        $this->Success($res);
    }
}
