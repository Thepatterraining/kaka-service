<?php

namespace App\Http\Controllers\User;

use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetVoucherStorage extends Controller
{
    protected $validateArray=[
        "pageIndex"=>"required|integer",
        "pageSize"=>"required|integer",
    ];

    protected $validateMsg = [
        "pageIndex.required"=>"请输入页码",
        "pageSize.required"=>"请输入每页数量",
        "pageIndex.integer"=>"页码必须是整数",
        "pageSize.integer"=>"每页数量必须是整数",
    ];

    /**
     * @api {post} user/getstorage 查询用户优惠券列表
     * @apiName getuserconpons
     * @apiGroup User
     * @apiVersion 0.0.1
     *
     * @apiParam {string} pageSize 每页数量
     * @apiParam {string} pageIndex 页码
     * @apiParam {string} filters.status 状态 可选 VOUS00 未使用 VOUS01 已经使用 VOUS02 过期
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      pageSize : "10",
     *      pageIndex: "1",
     *      filters : {
     *          status : 'VOUS00'
     *      }
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
     *                 "no" => "VCS2017040601523336102"
     *                   "voucherno" => "VCN2017031915460142475" 优惠券号
     *                   "activity" => "SA20170402193540898" 活动号
     *                   "userid" => 2 用户
     *                   "storagetime" => "2017.04.06" 发放时间
     *                   "status" => array:2 [ 状态
     *                    "no" => "VOUS00"
     *                    "name" => "未用"
     *                    ]
     *                    "jobno" => "" 关联单号
     *                    "usetime" => "1970-01-01 00:00:00" 使用时间
     *                    "outtime" => "2017.07.05" 过期时间
     *                    "info" => array:2 [
     *                    "val1" => 1000 满多少
     *                    "val2" => 10 减多少
     *                 ],
     *                    "note" : "房产项目2" //使用说明
     *
     *
     *      }
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $pageIndex = $request['pageIndex'];
        $pageSize = $request['pageSize'];
        $userId = $this->session->userid;
        $data = new VoucherStorageData();
        $adapter = new VoucherStorageAdapter();
        $infoData = new VoucherInfoData();

        //过期
        $data->overdue();

        $request['filters']['userid'] = $userId;
        $filters = $adapter->getFilers($request);
        $item = $data->getUserVoucher($filters, $pageSize, $pageIndex);

        $res = [];
        foreach ($item['items'] as $val) {
            //去字典表查询类型和状态
            $arr = $adapter->getDataContract($val);
            $arr['info'] = $infoData->getInfo($arr['voucherno']); //查找现金券的满减金额
            $arr['storagetime'] = date('Y.m.d', strtotime($arr['storagetime'])); //开始时间
            $arr['outtime'] = date('Y.m.d', strtotime($arr['outtime'])); //结束时间
            $arr['note'] = $infoData->getNote($arr['voucherno']); //查询使用条件
            $res[] = $arr;
        }
        $item['items'] = $res;
        return $this->Success($item);
    }
}
