<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use App\Http\Controllers\Controller;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupItemAdapter;
use App\Data\Auth\AuthGroupItemData;
use App\Data\Sys\ErrorData;
use App\Data\Auth\ItemData;
use App\Http\Adapter\Auth\ItemAdapter;

class DeleteAuth extends Controller
{

    protected $validateArray=[
        "authid"=>"required|exists:sys_auth_item,id",
    ];

    protected $validateMsg = [
        "authid.required"=>"请输入权限id!",
        "authid.exists"=>"权限id不存在!",
    ];

    /**
     * 更新权限
     */
    public function run()
    {
        $authid = $this->request->input('authid');

        $data = new ItemData;
        
        $data->delete($authid);


        return $this->Success();

    }
}
