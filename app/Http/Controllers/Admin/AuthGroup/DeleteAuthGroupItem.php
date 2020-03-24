<?php

namespace App\Http\Controllers\Admin\AuthGroup;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;

class DeleteAuthGroupItem extends Controller
{
    protected $validateArray=[
        "groupid"=>"required|exists:sys_auth_group,id",
        "userid"=>"required|exists:auth_user,id",
    ];

    protected $validateMsg = [
        "groupid.required"=>"管理组id!",
        "userid.required"=>"用户id!",
        "groupid.exists"=>"管理组id不存在!",
        "userid.exists"=>"用户id不存在!",
    ];

    public function run()
    {

        $groupid = $this->request->input('groupid');
        $userid = $this->request->input('userid');

        $authGroupData = new AuthGroupData;
        $authGroupData->removeMembers($groupid, $userid);

        return $this->Success();

    }
}
