<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;
use App\Data\Sys\CashJournalDocData;
use App\Data\User\CashFreezonDocData;
use App\Data\Sys\ErrorData;

class CreateCashFreezonDoc extends Controller
{
    protected $validateArray=[
        "userid"=>"required|exists:sys_user,id",
        "notes"=>"required",
    ];

    protected $validateMsg = [
        "amount.required"=>"请输入金额!",
        "userid.required"=>"请输入用户id!",
        "userid.exists"=>"用户不存在!",
        "notes.required"=>"请输入说明!",
    ];

    /**
     * 发起冻结
     *
     * @param  $amount 金额
     * @param  $userid 用户id
     * @param  $sysBankNo 系统卡号
     * @param  $note 说明
     * 去掉了金额
     * @author zhoutao
     * @date   2017.8.30
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $notes = $request['notes'];
        $userid = $request['userid'];

        $data = new CashFreezonDocData;

        $no = $data->createFrozen($notes, $userid);
        if (empty($no)) {
            return $this->Error(ErrorData::USER_FROZENED);
        }
        
        $this->Success($no);

    }
}
