<?php

namespace App\Http\Controllers\User;

use App\Data\User\CashOrderData;
use App\Http\Adapter\User\CashOrderAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetCashOrder extends QueryController
{
    /**
     * @api {post} user/getuserorder 查询资金账单列表
     * @apiName CashOrders
     * @apiGroup CashOrder
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} pageSize 每页数量
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageIndex : "1",
     *      pageSize : "10",
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
     *              "id" => 510
     *               "no" => "UCO2017052616592377863" 资金单号
     *               "type" => array:2 [  状态
     *               "no" => "UCORDER05"
     *               "name" => "充值"
     *               ]
     *               "jobno" => "CR2017052616592378773"  关联单号
     *               "price" => "3580.000"   金额
     *               "userid" => 262   用户id
     *               "balance" => "368346.205"  账户余额
     *               "date" => "2017-05-26 16:59:23"  时间
     *          },...
     *  }
     */
    public function getData()
    {
        return new CashOrderData();
    }

    public function getAdapter()
    {
        return new CashOrderAdapter();
    }

    protected function getMergeFilters($arr)
    {
        $arr['usercashorder_userid'] = $this->session->userid;
        return $arr;
    }

    protected function getItem($arr)
    {
        
        $arr['date'] = $arr['createdTime']->format('Y-m-d H:i:s');
        return $arr;
    }

}
