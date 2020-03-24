<?php

namespace App\Http\Controllers\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusData;

class GetBonus extends Controller
{

    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
        "coinType"=>"required",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "coinType.required"=>"请输入代币类型",
        "pageIndex.integer"=>"页码必须是整形",
        "pageSize.integer"=>"每页数量必须是整形",
    ];

    /**
     * @api {post} token/project/getbonus 查询分红列表
     * @apiName getbonus
     * @apiGroup Project
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     * @apiParam {string} coinType 代币类型
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : '1',
     *      pageSize  : 10,
     *      coinType : 'KKC-BJ0001';
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
     *              "instalment"  : '第001期', //分红期数
     *              "mobile" : "132****3442" //手机号
     *               "count" : "1" //确权份额 
     *               "status" : "已发放" //状态
     *          },...
     *      }   
     *  }
     */
    public function run()
    {
        $pageIndex = $this->request->input('pageIndex');
        $pageSize = $this->request->input('pageSize');
        $coinType = $this->request->input('coinType');

        $data = new ProjBonusData;
        $bonus = $data->getBonus($coinType, $pageIndex, $pageSize);

        $this->success($bonus);
    }
}
