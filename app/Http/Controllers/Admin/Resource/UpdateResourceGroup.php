<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Project\ProjectInfoData;
use App\System\Resource\Data\ResourceGroupData;

class UpdateResourceGroup extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "modelId"=>"required",
        "group"=>"required",
        "groupInclude"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入分组id",
        "modelId.required"=>"请输入项目id",
        "group.required"=>"请输入分组名称",
        "groupInclude.required"=>"请输入分组包含资源名称",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $modelId=$requests["modelId"];
        $group=$requests["group"];
        $groupInclude=$requests["groupInclude"];

        $data = new ProjectInfoData();
        $resourceGroupData=new ResourceGroupData();
        $define=$data->newitem()->where('id', $id)->first();
        if(!empty($define)) {
            $resourceGroupData->updateGroup($id, $modelId, $group, $groupInclude);
        }
        return $this->Success();
    }
}
