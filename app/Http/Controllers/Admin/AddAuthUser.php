<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddAuthUser extends Controller
{
    protected $validateArray=array(
        "data.loginid"=>"required",
        "data.mobile"=>"required",
        "data.pwd"=>"required",
        "data.email"=>"required"
    );

    protected $validateMsg = [
        "data.loginid.required"=>"请输入登录名!",
        "data.mobile.required"=>"请输入手机号！",
        "data.pwd.required"=>"请输入登陆密码！",
        "data.email.required"=>"请输入邮箱！"
    ];

    /**
     * 创建管理员
     *
     * @param   $data
     * @param   $pwd
     * @param   $email
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $pwd = $this->request->input('data.pwd');
        $email = $this->request->input('data.email');
        $data = new UserData();
        $adapter = new UserAdapter();
        $userInfo = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $userInfo, $model);
        $data->add($model, $pwd, $email);
        $this->Success('创建成功');
    }
}
