<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData as ProductInfoData;

class GetProjectCurves extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:product",
    ];

    protected $validateMsg = [
        "no.required"=>"请输入产品编号!",
    ];

    /**
     *
     *
     * @api {post} token/project/getcurves 查询项目曲线
     * @apiName 查询项目曲线
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} no 产品单据号
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      no : "PRO2017051712051590100",
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
     *           0 => array:5 [
     *               "no" => "KKC-BJ0001" 代币类型
     *               "id" => 3
     *               "price" => "419.17"  价格 
     *               "time" => "2012-10-06" 时间
     *               "pricetype" => array:2 [
     *                   "no" => "PROP01"
     *                   "name" => "人工录入"
     *               ]
     *           ],...
     *      }
     *  }
     */
    public function run()
    {
        $no = $this->request->input('no');

        $productInfoData = new ProductInfoData;
        $curves = $productInfoData->getCurves($no);

        $this->Success($curves);
    }
}
