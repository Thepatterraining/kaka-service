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

class CreateAuth extends Controller
{

    protected $validateArray=[
        // "parentNo"=>"required",
        "name"=>"required",
        "url"=>"required",
        "type"=>"required",
        "notes"=>"required",
    ];

    protected $validateMsg = [
        "notes.required"=>"请输入权限备注!",
        "type.required"=>"请输入权限类型!",
        "url.required"=>"请输入权限url!",
        "name.required"=>"请输入权限名称!",
        "parentNo.required"=>"请输入parentNo!",
    ];

    /**
     * 创建权限
     */
    public function run()
    {
        if ($this->request->has('parentNo')) {
            $parentNo = $this->request->input('parentNo');
        } else {
            $parentNo = null;
        }
        
        $name = $this->request->input('name');
        $url = $this->request->input('url');
        $type = $this->request->input('type');
        $notes = $this->request->input('notes');

        $data = new ItemData;
        
        $auth = $data->getAuth($url);

        if (empty($auth)) {
            $data->createAuth($parentNo, $name, $url, $type, $notes);
        }   
        

        return $this->Success();

    }

    
}
