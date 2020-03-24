<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\RegCofigData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteActivityConfig extends Controller
{
    protected $validateArray=[
        "userType"=>"required|dic:user_type",
    ];

    protected $validateMsg = [
        "userType.required"=>"请输入用户类型",
    ];

    /**
     * 删除配置
     *
     * @param   $userType 用户类型
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function run()
    {
        $request = $this->request->all();
        $userType = $request['userType'];

        $data = new RegCofigData();
        //查询
        $info = $data->getInfo($userType);
        if ($info == null) {
            return $this->Error(801010);
        }

        //删除
        $data->delConfig($userType);

        return $this->Success('删除成功');
    }
}
