<?php

namespace App\Http\Controllers\Admin\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;

class CreateCashJournalDoc extends Controller
{
    protected $validateArray=[
        "amount"=>"required",
        "fromBankCard"=>"required|exists:cash_bank_account,account_no",
        "toBankCard"=>"required|exists:cash_bank_account,account_no",
        "fromBankCardType"=>"required|dic:account_type",
        "toBankCardType"=>"required|dic:account_type",
        "notes"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "fromBankCard.required"=>"请输入出账卡!",
        "toBankCard.required"=>"请输入收账卡!",
        "fromBankCard.exists"=>"出账卡错误!",
        "toBankCard.exists"=>"收账卡错误!",
        "fromBankCardType.required"=>"请输入出账卡类型!",
        "toBankCardType.required"=>"请输入收账卡类型!",
        "notes.required"=>"请输入说明!",
    ];

    /**
     * 发起内部转账
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
        $fromBankCard = $request['fromBankCard'];
        $toBankCard = $request['toBankCard'];
        $fromBankCardType = $request['fromBankCardType'];
        $toBankCardType = $request['toBankCardType'];

        $data = new CashJournalDocData;

        $no = $data->createJournalDoc($notes, $fromBankCard, $toBankCard, $amount, $fromBankCardType, $toBankCardType);
        
        $this->Success($no);

    }
}
