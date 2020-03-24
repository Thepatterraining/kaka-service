<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveAuthPwd extends Controller
{
    protected $validateArray=array(
        "pwd"=>"required|pwd",
        "newPwd"=>"required|pwd",
    );

    protected $validateMsg = [
        "pwd.required"=>"请输入管理员旧密码！",
        "newPwd.required"=>"请输入管理员新密码！",
    ];

    /**
     * 修改管理原密码
     *
     * @param   $pwd
     * @param   $newPwd
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.6
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new UserData();
        $pwd = $request['pwd'];
        $newPwd = $request['newPwd'];

        $user = $data->get($this->session->userid);

        $checkRes = $data->checkPwd($user, $pwd);

        if ($checkRes == false) {
            return $this->Error(801003);
        }

        $checkRes = $data->checkPwd($user, $newPwd);

        if ($checkRes) {
            return $this->Error(801011);
        }

        if ($pwd == $newPwd) {
            return $this->Error(801011);
        }

        $res = $data->savePwd($user, $newPwd);

        $this->Success('修改密码成功！');
    }
}
