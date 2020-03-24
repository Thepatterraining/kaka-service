<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;

class CreatePayUser extends Controller
{
    protected $validateArray=[
        "amount"=>"required",
        "userid"=>"required",
        "sysBankNo"=>"required",
        "note"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "userid.required"=>"请输入用户id!",
        "sysBankNo.required"=>"请输入系统卡号!",
        "note.required"=>"请输入说明!",
    ];

    /**
     * 发起返现
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
        $userid = $request['userid'];
        $sysBankNo = $request['sysBankNo'];
        $note = $request['note'];

        $data = new PayUserData;

        $no = $data->createPay($sysBankNo, $userid, $amount, $note);
        
        $this->Success($no);

    }
}
