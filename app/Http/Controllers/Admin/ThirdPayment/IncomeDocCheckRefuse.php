<?php

namespace App\Http\Controllers\Admin\ThirdPayment;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocMD5Maker;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;
use App\Data\Payment\PayIncomedocsData;

class IncomeDocCheckRefuse extends Controller
{
    protected $validateArray=[
 
        "no"=>"required|doc:3rdindoc,INS00"
    ];

    protected $validateMsg = [
      
        "no.required"=>"请输入审核单号!"
    ];
    /**
     * 入帐失败
     *
     * @param   no 入帐单号
     * @author  zhoutao
     * @date    17.8.10
     * @version 0.1
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $docNo = $request['no'];
        
        
        //充值true or false
        $adminRechargeData = new UserRechargeData();

        $adminRechargeData->ThirdPartyRechargeIncomedocsFalse($docNo);

        $this->Success();
    }
}
