<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SendSmsData;
use App\Http\Controllers\Controller;

class SmsCode extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "verify"=>"required",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号!",
        "verify.required"=>"请输入验证码!",
    ];

    /**
     * 验证验证码
     *
     * @param   pohne 手机号
     * @param   verify 验证码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new SendSmsData();
        $phone = $this->request->input('phone');
        $verify = $this->request->input('verify');
        $res = $data->isVerfyCode($phone, $verify);
        if ($res !== true) {
            return $this->Success(false);
        }

        return $this->Success(true);
    }
}
