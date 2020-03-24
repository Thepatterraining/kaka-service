<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Data\Activity\StorageData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddUserActivity extends Controller
{
    protected $validateArray=array(
        "userid"=>"required|exists:sys_user,id",
        "activity"=>"required|exists:activity_info,activity_no",
    );

    protected $validateMsg = [
        "userid.required"=>"请输入用户id!",
        "userid.exists"=>"用户不存在，请重新输入!",
        "activity.required"=>"请输入活动编号！",
        "activity.exists"=>"活动编号不存在！",
    ];

    public function run()
    {
        $request = $this->request->all();
        $userid = $request['userid'];
        $activity = $request['activity'];

        $userData = new UserData();
        $user = $userData->get($userid);
        if ($user == null) {
            return $this->Error(801001);
        }

        $activityData = new InfoData();
        $activityInfo = $activityData->getByNo($activity);
        if ($activityInfo == null) {
            return $this->Error(809002);
        }
        if ($activityInfo->activity_status != 'ASS01') {
            return $this->Error(809002);
        }

        $activityStorageData = new StorageData();
        $activityStorageData->add($activity, 'ASS00', $userid);

        return $this->Success('发券成功');
    }
}
