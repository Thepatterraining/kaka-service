<?php

namespace App\Http\Controllers\TradeIndex;

use App\Data\Sys\ErrorData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\TradeIndexFactory;
use App\Http\Adapter\TradeIndex\TradeIndexAdapter;
use App\Data\Item\InfoData;

class GetTradeIndexes extends Controller
{
    protected $validateArray=[
        "coinType"=>"required",
        "start"=>"required",
        "type"=>"required",
        "end"=>"required",
    ];

    protected $validateMsg = [
        "coinType.required"=>"请输入代币类型!",
        "start.required"=>"请输入开始时间!",
        "type.required"=>"请输入代币类型!",
        "end.required"=>"请输入关闭时间!",
    ];

    /**
     * @api {post} token/trade/gettradeindexes 查询k线
     * @apiName 查询k线
     * @apiGroup TradeIndex
     * @apiVersion 0.0.1
     *
     * @apiParam {string} coinType 代币类型
     * @apiParam {datetime} start 开始时间
     * @apiParam {datetime} end 结束时间
     * @apiParam {string} type 类型 week day month hour
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinType : 'KKC-BJ0001',
     *      start  : 2017-08-17 00:00:00,
     *      end    : 2017-08-19 00:00:00,
     *      type   : 'day'
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
     *          {
     *              coinType  : KKC-BJ0001,
     *              priceOpen : 0, //开盘价
     *              priceClose : 0, //收盘价
     *              priceHigh : 0, //最高价
     *              priceLow : 0, //最低价
     *              volume : 0, // 成交量
     *              turnover_val : 0 //换手率,
     *              timeOpen : //开始时间,
     *              timeClose : //结束时间
     *          },...
     *      }   
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $coinType = $request['coinType'];
        $start = $request['start'];
        $end = $request['end'];
        $type = $request['type'];

        //查询
        $tradeIndexFac = new TradeIndexFactory;
        $tradeIndexAdapter = new TradeIndexAdapter;
        $tradeIndexs = $tradeIndexFac->queryIndex($type, $coinType, $start, $end);

        $res = [];
        if (!empty($tradeIndexs)) {
            foreach ($tradeIndexs as $index) {
                $index = $tradeIndexAdapter->getDataContract($index);
                $res[] = $index;
            }
        }
       
        //返回
        $this->Success($res);
    }
}
