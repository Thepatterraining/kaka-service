<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\BankAccountData;
use App\Data\User\UserBankCardData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddUserBank extends Controller
{
    protected $validateArray=[
        "bank_no"=>"required|digits_between:16,19|numeric",
        "phone"=>"required",
        "verfy"=>"required",
    ];

    protected $validateMsg = [
        "bank_no.required"=>"请输入银行卡号!",
        "bank_no.digits_between"=>"银行卡号最小16位,最大19位!",
        "bank_no.integer"=>"银行卡号必须是数字!",
        "phone.required"=>"请输入手机号!",
        "verfy.required"=>"请输入验证码!",
    ];

    /**
     * 添加用户银行卡信息
     *
     * @param   bank_no 银行卡号
     * @param   bank_name 银行名称
     * @param   bank_type 银行类型
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        //接收数据
        $request = $this->request->all();
        $bankno = $request['bank_no'];
        $bankname = $request['bank_name'];
        $banktype = $request['bank_type'];
        $phone = $request['phone'];
        $verfy = $request['verfy'];

        //验证手机号是正确的
        $userData = new UserData();
        $user = $userData->getUser($phone);
        if ($user == null) {
            return $this->Error(801015);
        }

        //验证验证码
        $sendSms = new SendSmsData();
        $smsRes = $sendSms->isVerfy($phone, $verfy);
        if ($smsRes === false) {
            return $this->Error(803002);
        }

        //查询绑定了几张银行卡
        $userBankData = new BankAccountData();
        $count = $userBankData->getUserBankCount();
        if ($count == 5) {
            return $this->Error(808003);
        }

        //执行
        $userBankCardData = new UserBankCardData();
        $userBankId = $userBankCardData->addBankCard($bankno);
        if ($userBankId === false) {
            return $this->Error(808002);
        }
 
        $this->Success($userBankId);
    }
}
