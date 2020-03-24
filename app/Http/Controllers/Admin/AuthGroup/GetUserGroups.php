<?php

namespace App\Http\Controllers\Admin\AuthGroup;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupItemData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Http\Adapter\Auth\AuthGroupAdapter;
use App\Data\Auth\AuthGroupData;

class GetUserGroups extends Controller
{
    protected $validateArray=[
        "userid"=>"required|exists:auth_user,id",
    ];

    protected $validateMsg = [
        "userid.required"=>"请输入用户id!",
        "userid.exists"=>"用户id不存在!",
    ];

    public function run()
    {

        $userid = $this->request->input('userid');

        $authGroupItemData = new AuthGroupItemData;
        $authGroupItemAdapter = new AuthGroupItemAdapter;
        $authGroupData = new AuthGroupData;
        $authGroupAdapter = new AuthGroupAdapter;
        $adminData = new UserData;
        $adminAdapter = new UserAdapter;

        $groups = $authGroupItemData->getGroups($userid);
        $res = [];
        if (!$groups->isEmpty()) {
            foreach ($groups as $groupuser) {
                $groupuser = $authGroupItemAdapter->getDataContract($groupuser);
                $group = $authGroupData->get($groupuser['groupid']);
                $groupuser['groupid'] = $authGroupAdapter->getDataContract($group);
                $admin = $adminData->get($groupuser['userid']);
                $groupuser['userid'] = $adminAdapter->getDataContract($admin);
                $res[] = $groupuser;
            }
        }

        return $this->Success($res);

    }
}
