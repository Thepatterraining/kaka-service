<?php

namespace App\Http\Controllers\Admin\AuthGroup;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Http\Adapter\Auth\AuthGroupAdapter;

class GetAuthGroupItems extends Controller
{
    protected $validateArray=[
        "groupid"=>"required|exists:sys_auth_group,id",
    ];

    protected $validateMsg = [
        "groupid.required"=>"管理组id!",
        "groupid.exists"=>"管理组id不存在!",
    ];

    public function run()
    {

        $groupid = $this->request->input('groupid');

        $authGroupData = new AuthGroupData;
        $authGroupAdapter = new AuthGroupAdapter;
        $authGroupItemAdapter = new AuthGroupItemAdapter;
        $adminData = new UserData;
        $adminAdapter = new UserAdapter;
        $groupUsers = $authGroupData->getMembers($groupid);
        $res = [];
        if (!$groupUsers->isEmpty()) {
            foreach ($groupUsers as $groupuser) {
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
