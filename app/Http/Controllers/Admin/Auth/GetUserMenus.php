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
use App\Data\Auth\AuthGroupData;


class GetUserMenus extends Controller
{
    

    public function run()
    {

        $userid =  $this->session->userid;

        $authGroupItemData = new AuthGroupItemData;
        $authGroupItemAdapter = new AuthGroupItemAdapter;
        $authItemData = new AuthItemData;
        $authItemAdapter = new AuthItemAdapter;
        $itemData = new ItemData;
        $itemAdapter = new ItemAdapter;
        $adminData = new UserData;
        $adminAdapter = new UserAdapter;
        $authGroupData = new AuthGroupData;
        // $groups = $adminData->get($userid)->authGroup()->get();

        $res = [];
        // foreach ($groups as $group) {
        //     $where['auth_type'] = 'AU01';
        //     $auths = $authGroupData->get($group->pivot->group_id)->auth()->where($where)->get();
        //     if (!$auths->isEmpty()) {
        //         foreach ($auths as $auth) {
        //             $auth = $itemAdapter->getDataContract($auth);
        //             $res[]  = $auth;
        //         }
                
        //     }
        // }

        
        $auths = $adminData->getUserMenus($userid);
        foreach ($auths as $auth) {
            $auth = $itemAdapter->getDataContract($auth);
            $res[] = $auth;
        }
        
        // dump($auths);
        return $this->Success($res);

    }
}
