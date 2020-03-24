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

class SaveAuth extends Controller
{

    protected $validateArray=[
        "authid"=>"required|exists:sys_auth_item,id",
        "data.no"=>"required",
        "data.name"=>"required",
        "data.url"=>"required",
        "data.type"=>"required",
        "data.notes"=>"required",
    ];

    protected $validateMsg = [
        "authid.required"=>"请输入权限id!",
        "authid.exists"=>"权限id不存在!",
        "data.notes.required"=>"请输入权限备注!",
        "data.type.required"=>"请输入权限类型!",
        "data.url.required"=>"请输入权限url!",
        "data.name.required"=>"请输入权限名称!",
        "data.no.required"=>"请输入no!",
    ];

    /**
     * 更新权限
     */
    public function run()
    {
        $authid = $this->request->input('authid');

        $data = new ItemData;
        $adapter = new ItemAdapter;
        
        $auth = $data->get($authid);
        
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $auth);
        $data->save($auth);

        $auth = $adapter->getDataContract($auth);


        return $this->Success($auth);

    }
}
