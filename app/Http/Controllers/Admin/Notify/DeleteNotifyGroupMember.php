<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupMemberData;
use App\Data\Sys\UserData;

class DeleteNotifyGroupMember extends Controller
{
    protected $validateArray=[
        "groupid"=>"required|exists:event_notifygroup,id",
        "authuserid"=>"required|exists:sys_user,id"
    ];

    protected $validateMsg = [
        "groupid.required"=>"请输入通知组id",
        "groupid.exists"=>" 通知组id不存在",
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
        $data->deletMember($groupId, $authUserId);

        return $this->Success();
    }
}
