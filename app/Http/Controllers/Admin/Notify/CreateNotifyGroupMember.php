<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;
use App\Data\Notify\NotifyGroupMemberData;
use App\Data\Auth\UserData;

class CreateNotifyGroupMember extends Controller
{
    protected $validateArray=[
        "groupid"=>"required|exists:event_notifygroup,id",
        "authuserid"=>"required|exists:auth_user,id",
    ];

    protected $validateMsg = [
        "groupid.required"=>"请输入通知组id",
        "groupid.exists"=>"通知组id不存在",
        "authuserid.required"=>"请输入管理员id",
        "authuserid.exists"=>"管理员id不存在"
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $groupId=$requests["groupid"];
        $authUserId=$requests["authuserid"];
        $data = new NotifyGroupMemberData();
        $userData=new UserData();
        $groupData=new NotifyGroupData();

        $memberInfo=$data->getInfo($groupId, $authUserId);
        if((empty($memberInfo))) {
            $userInfo=$userData->getuser($authUserId);
            $authUserName=$userInfo->auth_name;
            $authUserEmail=$userInfo->auth_email;
            $authUserMobile=$userInfo->auth_mobile;
            $authUserOpenId=null;
            $data->addNotifyGroupMember($groupId, $authUserId, $authUserName, $authUserEmail, $authUserMobile, $authUserOpenId);
        }

        return $this->Success();
    }
}
