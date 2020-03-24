<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\RegCofigData;
use App\Http\Adapter\Activity\RegCofigAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetActivityConfigInfo extends Controller
{
    protected $validateArray=[
        "userType"=>"required|dic:user_type",
    ];

    protected $validateMsg = [
        "userType.required"=>"请输入用户类型",
    ];

    /**
     * 查询配置详细
     *
     * @param   $userType
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function run()
    {
        $request = $this->request->all();
        $userType = $request['userType'];

        $data = new RegCofigData();
        $adapter = new RegCofigAdapter();

        $info = $data->getByNo($userType);
        if ($info == null) {
            return $this->Error(801010);
        }

        $res = [];
        $res = $adapter->getDataContract($info);

        return $this->Success($res);
    }
}
