<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Paypwd extends Controller
{
    protected $validateArray=[
        "pwd"=>"required",
        "paypwd"=>"required",
    ];

    protected $validateMsg = [
        "pwd.required"=>"请输入登陆密码!",
        "paypwd.required"=>"请输入支付密码!",
    ];


    /**
     * 验证支付密码和登陆密码是否一样
     *
     * @param   pwd 登陆密码
     * @param   paypwd 支付密码
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $pwd = $request['pwd'];
        $paypwd = $request['paypwd'];
        if ($pwd == $paypwd) {
            return $this->Error(801006);
        }

        return $this->Success(true);
    }
}
