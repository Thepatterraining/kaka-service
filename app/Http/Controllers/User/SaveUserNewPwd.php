<?php

namespace App\Http\Controllers\User;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;

class SaveUserNewPwd extends Controller
{
    protected $validateArray=[
        "pwd"=>"required",
        "newPwd"=>"required|pwd",
    ];

    protected $validateMsg = [
        "pwd.required"=>"请输入原登陆密码",
        "newPwd.required"=>"请输入新登陆密码",
    ];

    /**
     * 修改用户登陆密码
     *
     * @param   pwd 原密码
     * @param   newPwd 新密码
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.25
     */
    public function run()
    {
        $request = $this->request->all();
        $pwd = $request['pwd'];
        $newPwd = $request['newPwd'];
        $data = new UserData();
        $userInfo = $data->get($this->session->userid);
        $pwdRes = $data->checkPwd($userInfo, $pwd);
        if ($pwdRes !== true) {
            return $this->Error(ErrorData::$USRR_PWD_WRONG);
        }

        if ($newPwd == $pwd) {
            return $this->Error(ErrorData::$USER_PWD_UNIQUE);
        }

        //支付密码不能和登陆密码一样
        if ($data->checkPay($this->session->userid, $pwd)) {
            return $this->Error(ErrorData::$CHECK_PWD_PAY);
        }

        $res = $data->savePwd($newPwd);
        if ($res === false) {
            return $this->Error(ErrorData::$SAVE_FALSE);
        }
        $this->Success($res);
    }
}
