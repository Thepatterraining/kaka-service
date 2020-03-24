<?php

namespace App\Http\Controllers\Admin\Cash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;
use App\Data\Cash\JournalDocData;

class CreateJournalDoc extends Controller
{
    protected $validateArray=[
        "amount"=>"required",
        "bankCard"=>"required|exists:cash_bank_account,account_no",
        "type"=>"required",
        "bankCardType"=>"required|dic:account_type",
        "notes"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "bankCard.required"=>"请输入银行卡!",
        "type.required"=>"请输入类型!",
        "bankCard.exists"=>"银行卡错误!",
        "bankCardType.required"=>"请输入银行卡类型!",
        "notes.required"=>"请输入说明!",
    ];

    /**
     * 发起外部转账
     *
     * @param $amount 金额
     * @param $userid 用户id
     * @param $sysBankNo 系统卡号
     * @param $note 说明
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $amount = $request['amount'];
        $notes = $request['notes'];
        $bankCard = $request['bankCard'];
        $bankCardType = $request['bankCardType'];
        $type = $request['type'];

        $data = new JournalDocData;

        $no = $data->createJournalDoc($notes, $bankCard, $bankCardType, $amount, $type);
        
        $this->Success($no);

    }
}
