<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;

class SaveUserPayPwd extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "paypwd"=>"required|min:6|paypwd",
        "verify"=>"required",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号",
        "paypwd.required"=>"请输入支付密码",
        "paypwd.min"=>"支付密码最小6位",
        "paypwd.alpha_dash"=>"支付密码只能输入字母和数字，以及破折号和下划线",
        "verify.required"=>"请输入验证码",
    ];

    /**
     * 修改用户支付密码
     *
     * @param   phone 手机号
     * @param   paypwd 新支付密码
     * @param   verfy 验证码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $phone = $request['phone'];
        $verfy = $request['verify'];
        $paypwd = $request['paypwd'];

        $data = new UserData();
        $userInfo = $data->getUser($phone);

        if (empty($userInfo)) {
            return $this->Error(ErrorData::$USER_NOT_FOUND);
        }

        //验证码
        // $data = new SendSmsData();
        // $res = $data->isVerfy($phone, $verfy);
        // if ($res === false) {
        //     return $this->Error(803002);
        // }

        //修改支付密码
        $res = $data->savePayPwd($phone, $paypwd);
        if ($res['res'] === false) {
            return $this->Error($res['code']);
        }
        $this->Success('修改支付密码成功');
    }
}
