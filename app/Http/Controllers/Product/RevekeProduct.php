<?php

namespace App\Http\Controllers\Product;

use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionSellData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData;

class RevekeProduct extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:product,PRS01,PRS02",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入产品编号!",
    ];


    /**
     * @api {post} product/revokeproduct 撤销产品
     * @apiName revokeProduct
     * @apiGroup Product
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 产品编号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "PRO2017051003474018535"
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
     *      data :
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $productNo = $request['no'];
        //更新产品状态
        $productData = new InfoData();
        $productData->revoke($productNo);

        return $this->Success();
    }
}
