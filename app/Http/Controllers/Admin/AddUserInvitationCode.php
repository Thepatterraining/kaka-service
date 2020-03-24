<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\Activity\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddUserInvitationCode extends Controller
{
    protected $validateArray=[
        "userid"=>"required|exists:sys_user,id",
        "activityNo"=>"required|exists:activity_info,activity_no",
        "count"=>"required",
    ];

    protected $validateMsg = [
        "userid.required"=>"请输入用户id",
        "activityNo.required"=>"请输入活动编号",
        "count.required"=>"请输入要创建的数量",
        "userid.exists"=>"用户不存在",
        "activityNo.exists"=>"活动不存在",
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
        $userid = $request['userid'];
        $activityNo = $request['activityNo'];
        $count = $request['count'];

        //判断数量
        if ($count < 1) {
            return $this->Error(ErrorData::$ACTIVITY_CODE_COUNT);
        }

        //判断活动状态
        $activityData = new InfoData();
        $activityInfo = $activityData->getByNo($activityNo);
        $activityAdapter = new InfoAdapter();
        $activityInfo = $activityAdapter->getDataContract($activityInfo);
        if ($activityInfo['status']['no'] != 'AS01') {
            return $this->Error(ErrorData::$ACTIVITY_REQUIRED);
        }

        $data = new InvitationCodeData();
        //循环插入 $count 条邀请码
        for ($i = 0; $i < $count; $i++) {
            $data->add($activityNo, $userid);
        }

        $this->Success('创建成功');
    }
}
