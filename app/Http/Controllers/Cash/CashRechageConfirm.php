<?php

namespace App\Http\Controllers\Cash;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocMD5Maker;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;
use App\Data\CashRecharge\CashRechargeFactory;

class CashRechageConfirm extends Controller
{
    protected $validateArray=[
        "confirm"=>"required|boolean",
        "no"=>"required|doc:recharge,CR00",
    ];

    protected $validateMsg = [
        "confirm.required"=>"请输入确认值!",
        "no.required"=>"请输入充值单号!",
        "confirm.boolean"=>"确认值类型不正确!",
    ];
    
    /**
     * 确认充值
     *
     * @param   confirm 确认成功还是失败
     * @param   no 充值单号
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $rechargeNo = $request['no'];
        $confirm = $request['confirm'];
        // $request['body'];

        //充值true or false
        $rechargeFac = new CashRechargeFactory;
        $rechargeData = $rechargeFac->createData();

        if ($confirm == true) {
            $rechargeData->rechargeTrue($rechargeNo);
        } elseif ($confirm == false) {
            $rechargeData->rechargeFalse($rechargeNo);
        }

        $this->Success();
    }
}
