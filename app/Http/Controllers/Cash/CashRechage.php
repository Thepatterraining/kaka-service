<?php

namespace App\Http\Controllers\Cash;

use App\Data\Cash\RechargeData;
use App\Data\Cash\UserRechargeData;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Controllers\Controller;

class CashRechage extends Controller //step 2
{
    protected $validateArray=[
        "amount"=>"required",
        "phone"=>"required",
        "bankid"=>"required|exists:user_bank_account,account_no",
        "desbankid"=>"required|exists:cash_bank_account,account_no",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值金额!",
        "phone.required"=>"请输入手机号!",
        "bankid.required"=>"请输入银行卡号!",
        "desbankid.required"=>"请输入银行卡号!",
        "bankid.exists"=>"银行卡号不存在，请先绑定!",
        "desbankid.exists"=>"请输入正确的银行卡号!",
        "bankid.numeric"=>"银行卡号必须是数字!",
        "desbankid.numeric"=>"银行卡号必须是数字!",
    ];

    /**
     * 充值
     *
     * @param   amount 充值金额
     * @param   bankid 银行卡号
     * @param   desbankid 银行卡号
     * @author  zhoutao
     * @version 0.1
     */
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $amount = $request['amount'];
        $bankId = $request['bankid'];
        $desbankId = $request['desbankid'];
        $phone = $request['phone'];

        if ($amount <= 0) {
            return $this->Error(806004);
        }

        //验证手机号是正确的
        $userData = new UserData();
        $user = $userData->getUser($phone);
        if ($user == null) {
            return $this->Error(801015);
        }


        //生成单据号
        $docNo = new DocNoMaker();
        $rechargeNo = $docNo->Generate('CR');

        $date = date('Y-m-d H:i:s');
        //开始充值
        $RechargeData = new UserRechargeData();
        $res = $RechargeData->cashRechargeTwo($amount, $bankId, $desbankId, $rechargeNo, $phone, $date);


        //返回
        $this->Success($rechargeNo);
    }
}
