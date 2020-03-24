<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\ErrorData;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddUserPayPwd extends Controller
{
    protected $validateArray=[
        "paypwd"=>"required|min:6|paypwd",
    ];

    protected $validateMsg = [
        "paypwd.required"=>"请输入支付密码",
        "paypwd.min"=>"支付密码最小6位",
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
        $paypwd = $request['paypwd'];

        $data = new UserData();
        //验证支付密码是否为空
        $paypwdIsEmpty = $data->paypwdIsEmpty();

        //修改支付密码
        if ($paypwdIsEmpty === 0) {
            $res = $data->savePayPwd($this->session->userid, $paypwd);
            if ($res['res'] === false) {
                return $this->Error($res['code']);
            }
            return $this->Success();
        } elseif ($paypwdIsEmpty === 1) {
            return $this->Error(ErrorData::$USER_PAY_PWD_REQUIRED);
        } elseif ($paypwdIsEmpty == true && $paypwdIsEmpty !== true) {
            return $this->Error($paypwdIsEmpty);
        }
    }
}
