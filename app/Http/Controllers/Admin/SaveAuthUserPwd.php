<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveAuthUserPwd extends Controller
{
    protected $validateArray=array(
        "phone"=>"required",
    );

    protected $validateMsg = [
        "phone.required"=>"请输入管理员手机号！",
    ];

    /**
     * 重置管理原密码
     *
     * @param   $phone
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new UserData();
        $adapter = new UserAdapter();
        if (array_key_exists('pwd', $request)) {
            $pwd = $request['pwd'];
        } else {
            $pwd = '123456';
        }
        $phone = $request['phone'];

        $res = $data->forgetPwd($phone, $pwd);

        $this->Success('重置密码成功！');
    }
}
