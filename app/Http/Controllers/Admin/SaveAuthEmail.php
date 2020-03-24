<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveAuthEmail extends Controller
{
    protected $validateArray=array(
        "email"=>"required|email",
        "newEmail"=>"required|email",
    );

    protected $validateMsg = [
        "email.required"=>"请输入管理员旧邮箱！",
        "newEmail.required"=>"请输入管理员新邮箱！",
    ];

    /**
     * 修改管理原邮箱
     *
     * @param   $email      原邮箱
     * @param   $newEmail   新邮箱
     * @author  liu
     * @version 0.1
     * @date    2017.6.13
     */
    public function run()
    {
        $request = $this->request->all();
        $data = new UserData();
        $email = $request['email'];
        $newEmail = $request['newEmail'];

        $user = $data->get($this->session->userid);

        $checkRes = $data->checkEmail($user, $email);

        if ($checkRes == false) {
            return $this->Error(801021);
        }

        $checkRes = $data->checkEmail($user, $newEmail);

        if ($checkRes) {
            return $this->Error(801020);
        }

        if ($email == $newEmail) {
            return $this->Error(801020);
        }

        $res = $data->saveEmail($user, $newEmail);

        $this->Success('修改密码成功！');
    }
}
