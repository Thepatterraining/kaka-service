<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusData;

class AddBonus extends Controller
{
    protected $validateArray=[
        "rightNo"=>"required",
        "amount"=>"required",
        "planfee"=>"required",
        "starttime"=>"required",
        "endtime"=>"required",
        "unit"=>"required",
        "coinType"=>"required",
        "authDate"=>"required",
        "bonusInstalment"=>"required",
        "bonusCycle"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "rightNo.required"=>"请输入确权单号!",
        "planfee.required"=>"请输入管理费用!",
        "unit.required"=>"请输入最小单位!",
        "starttime.required"=>"请输入开始时间!",
        "endtime.required"=>"请输入结束时间!",
        "coinType.required"=>"请输入代币类型!",
        "authDate.required"=>"请输入确权日期",
        "bonusInstalment.required"=>"请输入分红期数",
        "bonusCycle.required"=>"请输入分红周期",
    ];

    /**
     * 发起分红
     *
     * @param $amount 总金额
     * @param $rightNo 确权单号
     * @param $planfee 管理费
     * @param $unit 最小单位
     * @param $starttime 开始时间
     * @param $endtime 结束时间
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $amount = $request['amount'];
        $rightNo = $request['rightNo'];
        $planfee = $request['planfee'];
        $unit = $request['unit'];
        $starttime = $request['starttime'];
        $endtime = $request['endtime'];
        $coinType = $request['coinType'];
        $authDate = $request['authDate'];
        $bonusInstalment = $request['bonusInstalment'];
        $bonusCycle = $request['bonusCycle'];

        $data = new ProjBonusData;
        $no = $data->createBonus($rightNo, $authDate , $amount, $planfee, $unit, $starttime, $endtime, $coinType, $bonusInstalment, $bonusCycle);
        $this->Success($no);

    }
}
