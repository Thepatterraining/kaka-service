<?php
namespace App\Http\Controllers\Cash;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocMD5Maker;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;

/**
 * floor the recharge ;
 *
 * @param   no the doc no of recharge ;
 * @version 0.1
 * @author  geyunfei (geyunfei@kakamf.com)
 **/
class CashRechargeFloor extends Controller
{
    
    
    
    protected $validateArray=[
      
        "no"=>"required|doc:recharge,CR00"
    ];

    protected $validateMsg = [
      
        "no.required"=>"请输入充值单号!"
    ];
   
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $rechargeNo = $request['no'];
 
        // $request['body'];
        //生成单据号
        $docNo = new DocNoMaker();
        
        //充值true or false
        $adminRechargeData = new UserRechargeData();


        $adminRechargeData -> flowRecharge($rechargeNo);

        $this->Success();
    }
}
