<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\BankAccountData;
use App\Data\User\UserBankCardData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityGetVoucher extends Controller
{
    protected $validateArray=[
        "activityNo"=>"required",
    ];

    protected $validateMsg = [
        "activityNo.required"=>"请输入活动号!",
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
        $activityNo = $request['activityNo'];

        
        $this->Success($activityNo);
    }
}
