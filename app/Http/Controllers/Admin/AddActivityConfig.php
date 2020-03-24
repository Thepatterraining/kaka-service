<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegCofigData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Activity\InfoAdapter;
use App\Http\Adapter\Activity\RegCofigAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddActivityConfig extends Controller
{
    protected $validateArray=[
        "data.usertype"=>"required|dic:user_type",
        "data.code"=>"required|exists:activity_info,activity_no",
    ];

    protected $validateMsg = [
        "data.usertype.required"=>"请输入用户类型",
        "data.code.required"=>"请输入活动编号",
        "data.code.exists"=>"活动不存在",
    ];

    /**
     * 给用户创建 $count 条邀请码
     *
     * @param   $userid
     * @param   $activityNo
     * @param   $count
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.12
     */
    public function run()
    {
        $request = $this->request->all();
        $userType = $request['data']['usertype'];

        $data = new RegCofigData();
        $adapter = new RegCofigAdapter();

        $info = $data->getByNo($userType);
        if ($info != null) {
            return $this->Error(ErrorData::$ACTIVITY_UNIQUE);
        }

        $model = $data->newitem();
        $configInfo = $adapter->getData($this->request);
        
        $adapter->saveToModel(false, $configInfo, $model);
        $data->create($model);


        $this->Success('创建成功');
    }
}
