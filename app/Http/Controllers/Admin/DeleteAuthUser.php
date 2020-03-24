<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteAuthUser extends Controller
{
    protected $validateArray=array(
        "phone"=>"required",
    );

    protected $validateMsg = [
        "phone.required"=>"请输入要删除的手机号！",
    ];

    /**
     * 删除管理员
     *
     * @param   $phone 手机号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $phone = $this->request->input('phone');

        $data = new UserData();
        $userInfo = $data->getUser($phone);
        if ($userInfo == null) {
            return $this->Error(801001);
        }
        $data->delUser($phone);
        $this->Success('删除成功！');
    }
}
