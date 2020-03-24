<?php
namespace App\Http\Controllers\Cash;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\DocMD5Maker;
use App\Http\Controllers\Controller;
use App\Data\Utils\DocNoMaker;

/**
 * change the amount of recharge ;
 *
 * @param   no the no of recharge ;
 * @param   ammount,the new value ;
 * @version 0.1
 * @author  geyunfei (geyunfei@kakamf.com)
 **/
class CashRechargeChange extends Controller
{
    
    
    
    protected $validateArray=[
        "amount"=>"required|numeric",
        "no"=>"required|doc:recharge,CR00",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入要更改的值!",
        "no.required"=>"请输入充值单号!",
        "amount.numeric"=>"更改的值的类型不正确!",
    ];
    
    
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $rechargeNo = $request['no'];
        $amount = $request['amount'];
        // $request['body'];
        //生成单据号
        $docNo = new DocNoMaker();
        $journaNo = $docNo->Generate('CCJ');
        $userJournalNo = $docNo->Generate('UCJ');

        //充值true or false
        $adminRechargeData = new UserRechargeData();


        $adminRechargeData -> changeRechargeAmount($rechargeNo, $amount);

        $this->Success();
    }
}
