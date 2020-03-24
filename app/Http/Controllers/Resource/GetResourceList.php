<?php

namespace App\Http\Controllers\Resource;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\Sys\ModelData;
use App\System\Resource\Data\ResourceIndexData;
use App\System\Resource\Data\StoreItemInfoData;

class GetResourceList extends Controller
{
    protected $validateArray=[
        "modelid"=>"required",
        "itemid"=>"required",
    ];

    protected $validateMsg = [
        "modelid.required"=>"请输入类型id!",
        "itemid.required"=>"请输入资源相关id，如用户id、项目id等!",
    ];
    
    public function run()
    {
        $request=$this->request->all();
        $modelId=$request['modelid'];
        $itemId=$request['itemid'];
        $modelData=new ModelData;
        $model=$modelData->get($modelId);//获取模型id

        if($model==null) {
            return $this->Error(ErrorData::ERROR_ITEM_NO);
        }
        $resourceIndexData=new ResourceIndexData;
        $resourceId=$resourceIndexData->getResourceId($modelId, $itemId);//获取索引信息
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