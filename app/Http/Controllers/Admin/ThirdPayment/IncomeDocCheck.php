<?php

namespace App\Http\Controllers\Admin\ThirdPayment;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocMD5Maker;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;
use App\Data\Payment\PayIncomedocsData;

class IncomeDocCheck extends Controller
{
    protected $validateArray=[
 
        "no"=>"required|doc:3rdindoc,INS00"
    ];

    protected $validateMsg = [
      
        "no.required"=>"请输入审核单号!"
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
        $docNo = $request['no'];
        
        
        //充值true or false
        $adminRechargeData = new UserRechargeData();

        $adminRechargeData->ThirdPartyRechargeIncomedocsTrue($docNo);
        /*
        $date = date('Y-m-d H:i:s');
        if ($confirm == true) {
            $body ="null";
            $res = $adminRechargeData->trueRechargeTwo($journaNo,$userJournalNo,$rechargeNo,$body,$date);
        } else if ($confirm == false) {
            $body ="CRB00";
            $res = $adminRechargeData->falseRechargeTwo($rechargeNo,$body,$date);
        }

        if ($res === false) {
            return $this->Error();
        }
        if ($confirm == true) {
            $this->Success('审核成功');
        } else {
            $this->Success('审核拒绝成功');
        }*/
        $this->Success();
    }
}
