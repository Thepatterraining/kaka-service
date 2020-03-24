<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Data\Auth\AuthGroupItemData;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AuthItemData;

class DeleteAuthItem extends Controller
{

    protected $validateArray=[
        "authid"=>"required|exists:sys_auth_item,id",
        "groupid"=>"required|exists:sys_auth_group,id",
    ];

    protected $validateMsg = [
        "authid.required"=>"请输入权限id!",
        "groupid.required"=>"请输入管理组id!",
        "authid.exists"=>"权限id不存在!",
        "groupid.exists"=>"管理组id不存在!",
    ];
        
    /**
     * 把权限和管理组关联解除
     */
    public function run()
    {
        $authid = $this->request->input('authid');
        $groupid = $this->request->input('groupid');

        $data = new AuthItemData;
        
        $data->remove($authid, $groupid);

        return $this->Success();

    }
}
