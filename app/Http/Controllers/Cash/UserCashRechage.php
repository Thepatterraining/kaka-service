<?php

namespace App\Http\Controllers\Cash;

use App\Http\Controllers\Controller;
use App\Data\Cash\FinanceBankData;
use App\Data\Sys\ErrorData;
use App\Data\CashRecharge\CashRechargeFactory;

class UserCashRechage extends Controller //step 2
{
    protected $validateArray=[
        "amount"=>"required",
        "phone"=>"required",
        "bankid"=>"required|min:16|max:19",
        "name"=>"required",
        "bankNo"=>"required|exists:finance_bank,bank_no",
        "verify"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入充值金额!",
        "phone.required"=>"请输入手机号!",
        "bankid.required"=>"请输入汇款银行账号!",
        "desbankid.required"=>"请输入银行卡号!",
        "bankid.exists"=>"汇款银行账号不存在，请先绑定!",
        "desbankid.exists"=>"请输入正确的银行卡号!",
        "bankid.numeric"=>"汇款银行账号必须是数字!",
        "desbankid.numeric"=>"银行卡号必须是数字!",
        "name.required"=>"请输入汇款人姓名!",
        "bankNo.required"=>"请输入汇款银行!",
        "bankid.min"=>"汇款银行账号最小16位!",
        "bankid.max"=>"汇款银行账号最大19位!",
        "verify.required"=>"请输入短信验证码!",
    ];

    /**
     * 充值
     * 
     * 增加了汇款人姓名，银行，短信验证码
     * 增加了绑卡业务
     *
     * @version 0.2
     * @author  zhoutao
     * 
     * @param   $amount 充值金额
     * @param   $bankid 用户银行卡号
     * @param   $desbankid 银行卡号
     * @param   $phone 手机号
     * @param   $name 名称
     * @param   $verify 短信验证码
     * @param   $bankNo 银行号
     * @author  zhoutao
     * @version 0.1
     */
    public function run() //step 3
    {
        //接收数据
        $request = $this->request->all();
        $amount = $request['amount'];
        $bankId = $request['bankid'];
        $phone = $request['phone'];
        $name = $request['name'];
        $bankNo = $request['bankNo'];


        $branchName = "默认支行";

        if (array_key_exists("branchName", $request)) {
            $branchName = $request['branchName'];
        }

        if ($amount <= 0) {
            return $this->Error(ErrorData::RECHARGE_AMOUNT_GT_ZERO);
        }

        //处理银行卡号
        $bankId = str_replace(' ', '', $bankId);
        if (!is_numeric($bankId)) {
            return $this->Error(ErrorData::$BANK_CARD_FALSE);
            
        }

        //添加银行卡
        $FinanceBankData = new FinanceBankData();
        $FinanceBankData->addBankCard( $bankId, $name, $branchName, $phone, $bankNo);

        //开始充值
        $rechargeFac = new CashRechargeFactory;
        $rechargeData = $rechargeFac->createData();
        $res = $rechargeData->recharge($amount, $bankId, $phone);

        if ($res['success'] === false) {
            return $this->Error($res['code']);
        }
        //返回
        $this->Success($res['msg']);
    }
}
