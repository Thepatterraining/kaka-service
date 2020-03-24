<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveUserPhone extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "newPhone"=>"required|unique:sys_user,user_mobile",
        "verify"=>"required",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号",
        "newPhone.required"=>"请输入新手机号",
        "newPhone.unique"=>"新手机号已注册",
        "verify.required"=>"请输入验证码",
    ];

    /**
     * 修改用户登陆密码
     *
     * @param   phone 手机号
     * @param   newPhone 新手机号
     * @param   verify 新密码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $phone = $request['phone'];
        $verfy = $request['verify'];
        $newPhone = $request['newPhone'];

        //验证码
        // $data = new SendSmsData();
        // $res = $data->isVerify($newPhone, $verfy);
        // if ($res === false) {
        //     return $this->Error(803002);
        // }

        //写入新手机号
        $userData = new UserData();
        //两个手机号不能一样
        if ($phone == $newPhone) {
            return $this->Error(801008);
        }

        $userRes = $userData->savePhone($phone, $newPhone);
        if ($userRes === false) {
            return $this->Error(801007);
        }

        $this->Success(true);
    }
}
