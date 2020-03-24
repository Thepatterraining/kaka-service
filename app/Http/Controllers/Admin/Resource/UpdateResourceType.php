<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Project\ProjectInfoData;
use App\System\Resource\Data\ResourceTypeData;

class UpdateResourceType extends Controller
{
    protected $validateArray=[
        "id"=>"required",
        "typeName"=>"required",
        "fileType"=>"required",
        "modelId"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入类型id",
        "modelId.required"=>"请输入项目id",
        "typeName.required"=>"请输入资源类型",
        "fileType.required"=>"请输入资源类型后缀",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $modelId=$requests["modelId"];
        $typeName=$requests["typeName"];
        $fileType=$requests["fileType"];
        // $preLogic=$requests["preLogic"];
        // $preParam=$requests["preParam"];
        // $postLogic=$requests["postLogic"];
        // $postParam=$requests["postParam"];

        $data = new ProjectInfoData();
        $resourceTypeData=new ResourceTypeData();
        $define=$data->newitem()->where('id', $id)->first();
        if(!empty($define)) {
            $resourceTypeData->updateType($modelId, $typeName, $fileType, $preLogic = null, $preParam = null, $postLogic = null, $postParam = null);
        }
        return $this->Success();
    }
}
