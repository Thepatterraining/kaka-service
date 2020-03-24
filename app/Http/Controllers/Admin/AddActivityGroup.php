<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\GroupData;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Activity\GroupAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddActivityGroup extends Controller
{
    protected $validateArray=[
        "name"=>"required",
        "type"=>"required",
    ];

    protected $validateMsg = [
        "name.required"=>"请输入活动分组名称",
        "type.required"=>"请输入活动分组类型",
    ];

    /**
     * 添加现金券
     *
     * @param   $name 活动分组名称
     * @param   $type 活动分组类型
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $name = $request['name'];
        $type = $request['type'];
        
        $data = new GroupData();
        $groupInfo = $data->addGroup($name, $type);

        $adapter = new GroupAdapter();
        $groupInfo = $adapter->getDataContract($groupInfo);

        $no = array_get($groupInfo, 'no');
        $this->Success($no);
    }
}
