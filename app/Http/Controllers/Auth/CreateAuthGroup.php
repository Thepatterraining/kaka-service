<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupAdapter;

class CreateAuthGroup extends Controller
{

    protected $validateArray=[
        "data.groupName"=>"required",
        "data.groupNote"=>"required",
    ];

    protected $validateMsg = [
        "data.groupName.required"=>"管理组名称!",
        "data.groupNote.required"=>"管理组备注!",
    ];

    /**
     * 创建管理组
     *
     * @param   $groupName 管理组名称
     * @param   $groupNote 管理组备注
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {

        $data = new AuthGroupData();
        $adapter = new AuthGroupAdapter;
        $model = $data->newitem();
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $model);
        $data->create($model);

        return $this->Success();
    }
}
