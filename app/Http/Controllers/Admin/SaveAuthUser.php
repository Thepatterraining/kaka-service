<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveAuthUser extends Controller
{
    protected $validateArray=array(
    //        "pwd"=>"required",
    );

    protected $validateMsg = [
    //        "pwd.required"=>"请输入登陆密码！",
    ];

    /**
     * 修改用户信息
     *
     * @param   $data
     * @param   $pwd
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $data = new UserData();
        $adapter = new UserAdapter();
        //        $pwd = $this->request->input('pwd');

        //数据转换，赋值
        $newsInfo = $adapter->getData($this->request);
        $model = $data->get($this->session->userid);
        $adapter->saveToModel(false, $newsInfo, $model);
        $data->save($model);
        //        $res = $data->savePwd($model,$pwd);

        $this->Success('修改成功');
    }
}
