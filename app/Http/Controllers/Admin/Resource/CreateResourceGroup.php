<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Project\ProjectInfoData;
use App\System\Resource\Data\ResourceGroupData;

class CreateResourceGroup extends Controller
{
    protected $validateArray=[
        "modelId"=>"required",
        "group"=>"required",
        "groupInclude"=>"required",
        "groupLevel"=>"requeired"
    ];

    protected $validateMsg = [
        "modelId.required"=>"请输入项目id",
        "group.required"=>"请输入分组名称",
        "groupInclude.required"=>"请输入分组包含资源名称",
        "groupLevel.required"=>"情输入组别展示优先级"
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $modelId=$requests["modelId"];
        $group=$requests["group"];
        $groupInclude=$requests["groupInclude"];
        $groupLevel=$requests["groupLevel"];

        $data = new ProjectInfoData();
        $resourceGroupData=new ResourceGroupData();
        $define=$data->newitem()->where('id', $id)->first();
        if(!empty($define)) {
            $resourceGroupData->add($modelId, $group, $groupInclude, $groupLevel);
        }
        return $this->Success();
    }
}
