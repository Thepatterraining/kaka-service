<?php

namespace App\Http\Controllers\Admin\AuthGroup;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Data\Auth\AuthGroupItemData;
use App\Data\Sys\ErrorData;

class AddAuthGroupItem extends Controller
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

        $authGroupItemData = new AuthGroupItemData;
        $authGroupData = new AuthGroupData;

        $groupUser = $authGroupItemData->getUser($groupid, $userid);

        if (!empty($groupUser)) {
            return $this->Error(ErrorData::$AUTH_GROUP_USER_UNIQUE);
        } 

        $authGroupData->addMembers($groupid, $userid);

        return $this->Success();

    }
}
