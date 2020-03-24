<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusPlanData;

class CreateBonusPlan extends Controller
{
    protected $validateArray=[
        "typeid"=>"required",
        "amount"=>"required",
        "planfee"=>"required",
        "starttime"=>"required",
        "endtime"=>"required",
        "unit"=>"required",
        "coinType"=>"required",
        "startIndex"=>"required",
        "autoCheck"=>"required"
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "typeid.required"=>"请输入计划类型!",
        "planfee.required"=>"请输入管理费用!",
        "unit.required"=>"请输入最小单位!",
        "starttime.required"=>"请输入开始时间!",
        "endtime.required"=>"请输入结束时间!",
        "coinType.required"=>"请输入代币类型!",
        "startIndex.required"=>"请输入开始分红的期数",
        "autoCheck.required"=>"请输入是否自动执行",
    ];

    /**
     * 创建分红计划
     *
     * @author zhoutao
     * @date   2017.11.8
     */
    protected function run()
    {
        $request = $this->request->all();
        $amount = $request['amount'];
        $planfee = $request['planfee'];
        $unit = $request['unit'];
        $startTime = $request['starttime'];
        $endTime = $request['endtime'];
        $coinType = $request['coinType'];
        $typeid = $request['typeid'];
        $startIndex = $request['startIndex'];
        $autoCheck = $request['autoCheck'];

        $data = new ProjBonusPlanData;

        $no = $data->add($coinType, $planfee, $amount, $unit, $autoCheck, $typeid, $startTime, $endTime, $startIndex);
        
        $this->Success($no);

    }
}
