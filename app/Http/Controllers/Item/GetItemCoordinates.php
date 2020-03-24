<?php

namespace App\Http\Controllers\Item;

use App\Data\Item\InfoData;
use App\Data\Trade\TranactionOrderData;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData as ProductInfoData;

class GetItemCoordinates extends Controller
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
     * @api {post} token/project/getcoordinates 查询项目坐标
     * @apiName 查询项目坐标
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
     *              "house" => array:5 [
     *               "coordinate_x" => "1.00000"
     *               "coordinate_y" => "1.00000"
     *               "school_name" => ""
     *               "coinType" => "KKC-BJ0001"
     *            "type" => array:2 [
     *                   "no" => "IC01"
     *                   "name" => "房产"
     *             ]
     *               ]
     *               "schools" => array:1 [
     *               0 => array:5 [
     *                   "coordinate_x" => "2.00000"
     *                   "coordinate_y" => "2.00000"
     *                   "school_name" => "一号小雪"
     *                   "coinType" => "KKC-BJ0001"
     *                   "type" => array:2 [
     *                   "no" => "IC02"
     *                   "name" => "学校"
     *                   ]
     *                  ],...
     *      }
     *  }
     */
    public function run()
    {
        $no = $this->request->input('no');

        $data = new ProductInfoData();
        $res = $data->getCoordinate($no);

        $this->Success($res);
    }
}
