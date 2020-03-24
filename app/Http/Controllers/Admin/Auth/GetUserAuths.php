<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthItemData;
use App\Http\Adapter\Auth\AuthItemAdapter;
use App\Http\Adapter\Auth\ItemAdapter;
use App\Data\Auth\ItemData;
use App\Data\Auth\AuthGroupItemData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;

class GetUserAuths extends Controller
{
    protected $validateArray=[
        
    ];

    protected $validateMsg = [

    ];

    public function run()
    {

        $userid = $this->session->userid;

        $authGroupItemData = new AuthGroupItemData;
        $authGroupItemAdapter = new AuthGroupItemAdapter;
        $authItemData = new AuthItemData;
        $authItemAdapter = new AuthItemAdapter;
        $itemData = new ItemData;
        $itemAdapter = new ItemAdapter;
        $adminData = new UserData;
        $adminAdapter = new UserAdapter;
        
        $groups = $authGroupItemData->getGroups($userid);
        $res = [];
        if (!$groups->isEmpty()) {
            foreach ($groups as $groupuser) {
                $groupuser = $authGroupItemAdapter->getDataContract($groupuser);
                $auths = $authItemData->getAuths($groupuser['groupid']);
                if (!$auths->isEmpty()) {
                    foreach ($auths as $auth) {
                        $arr = $authItemAdapter->getDataContract($auth);
                        $auth = $itemData->get($arr['authid']);
                        $auth = $itemAdapter->getDataContract($auth);
                        $arr['authid'] = $auth;
                        $groupuser['auth'][] = $arr;
                    }
                }
                $admin = $adminData->get($groupuser['userid']);
                $groupuser['userid'] = $adminAdapter->getDataContract($admin);
                $res[] = $groupuser;
            }
        }

        return $this->Success($res);

    }
}
