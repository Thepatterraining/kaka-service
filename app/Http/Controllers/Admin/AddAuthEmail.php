<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddAuthEmail extends Controller
{
    protected $validateArray=array(
        //"data.loginid"=>"required",
        "email"=>"required",
    );

    protected $validateMsg = [
        "email.required"=>"请输入邮箱！",
    ];

    /**
     * 新增邮箱
     *
     * @param   $email 邮箱名称
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $request=$this->request->all();
        $email = $request['email'];
        $data = new UserData();
        $adapter = new UserAdapter();
        $userInfo = $data->get($this->session->userid);
        if($userInfo->auth_email != '') {
            return $this->Error(801022);
        }

        $userInfo->auth_email=$email;
        $model = $data->newitem();
        //var_dump($userInfo);
        $adapter->saveToModel(false, $userInfo, $model);
        $data->saveEmail($userInfo, $email);
        //var_dump($model);
        //$adapter->getFromModel($model,true);
        $this->Success('新建邮箱成功');
    }
}
