<?php

namespace App\Http\Controllers\Admin\Resource;

use App\System\Resource\Data\ResourceIndexData;
use App\Http\Adapter\Activity\ResourceIndexAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;

class GetResourceList extends Controller
{
    protected $validateArray=[
        "info"=>"required",
    ];

    protected $validateMsg = [
        "info.required"=>"请输入索引id",
    ];
    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $info=$requests["info"];

        $data=new ModelData();
        $resourceIndexData=new ResourceIndexData();
        $modelId=$data->getModelIdByModel($info);
        if($modelId==null) {
            return $this->Error(ErrorData::ERROR_ITEM_NO);
        }
        $resourceIndexData=new ResourceIndexData;
        $resourceId=$resourceIndexData->getResourceId($modelId);//获取索引信息
        $storeInfoData=new StoreItemInfoData;
        if(!$resourceId->isEmpty()) {
            foreach($resourceId as $resource)
            {
                $storeInfo[]=$storeInfoData->GetById($resource->resource_id);//获取存储信息
            }
        }
        else
        {
            $storeInfo=null;
        }
        return $this->Success($storeInfo);
    }
}
