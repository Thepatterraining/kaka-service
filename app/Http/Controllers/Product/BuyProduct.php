<?php

namespace App\Http\Controllers\Product;

use App\Data\Product\InfoData;
use App\Data\Sys\ErrorData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BuyProduct extends Controller
{
    protected $validateArray=[
        "count"=>"required|numeric",
        "no"=>"required|doc:product,PRS02,PRS06",
    ];

    protected $validateMsg = [
        "count.required"=>"请输入数量!",
        "no.required"=>"请输入产品号!",
    ];

    /**
     * @api {post} product/buyproduct 购买产品
     * @apiName buyProduct
     * @apiGroup Product
     * @apiversion 0.0.1
     *
     * @apiParam {string} no 产品单据号
     * @apiParam {number} count 购买数量
     * @apiParam {string} voucherNo 现金券号 可选
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no      : 'PRO2017051712051590100',
     *      count   : 25 ,
     *      voucherNo : 'VCS2017041122122624583'
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
     *          count : 数量,
     *          order : {
     *              price : 价格
     *              data : 时间
     *              rose : 月涨幅
     *          }
     *      }
     *  }
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $count = $request['count'];
        $no = $request['no'];

        $voucherNo = '';
        // dd($this->request->all());
        if ($this->request->has('voucherNo')) {
            $voucherNo = $this->request->input('voucherNo');
        }

        //查询产品
        $infoData = new InfoData();
        $infoAdapter = new InfoAdapter();
        // $res = $infoData->buyProduct($no, $count, $voucherNo);
        $res = [
            'count' => 1,
            'order' => [
                'price' => 1550
            ],
        ];

        if (count($res) > 1) {
            return $this->Success($res);
        } else {
            return $this->Error($res);
        }
    }
}
