<?php 
namespace App\System\Resource\Data;
use App\Data\Project\ProjectInfoData;
use App\Data\Sys\ModelData;
use App\Data\IDataFactory;

class ResourceIndexData extends IDataFactory
{
    protected $modelclass="App\System\Resource\Model\ResourceIndex";

    const OVERVIEW_IMG = '总览图';
    const LOCATION_IMG = '外景图'; 
    const COMPANY_SIGN = '公章';
    const NEWS_IMG = '公告图';
    const CONTRACT_IMG = '租赁合同';

    /**
     * 添加索引信息
     *
     * @param   $typeId 类型id
     * @param   $modelId 模型id
     * @param   $storeId 存储id
     * @param   $name  资源所属类别名称
     * @author  liu
     * @version 0.1
     */
    public function add($typeId,$modelId,$storeId,$name,$itemId)
    {
        $modelData=new ModelData();
        $modelInfo=$modelData->newitem()->where('id', $modelId)->first();

        $model=$this->newitem();
        $model->resource_id=$storeId;
        $model->resource_typeid=$typeId;
        $model->resource_modelid=$modelId;
        $model->resource_modelname=$modelInfo->model_name;
        $model->resource_name=$name;
        $model->resource_itemno=$itemId;
        $model->save();
    }
    /**
     * 通过模型id获得索引信息
     *
     * @param   $modelId 模型id
     * @author  liu
     * @version 0.1
     */
    public function getResourceId($modelId,$itemId)
    {
        $model=$this->newitem();
        $res=$model->where('resource_modelid', $modelId)->where('resource_itemno', $itemId)->get();
        return $res;
    }

    public function getItem($modelId,$itemId,$resourceInclude)
    {
        $model=$this->newitem();
        $resourceStoreData=new StoreItemInfoData();
        $resourceTypeData=new ResourceTypeData();

        $res=array();
        $resourceName=explode(" ", $resourceInclude);
        if($resourceName) {
            foreach($resourceName as $name)
            {
                $resourceInfo=$model->where('resource_modelid', $modelId)->where('resource_itemno', $itemId)->where('resource_name', $name)->get();
                if(!$resourceInfo->isEmpty()) {
                    foreach($resourceInfo as $info)
                    {
                        $resourceTypeInfo=$resourceTypeData->getByNo($info->resource_typeid);
                        $resourceUrlInfo=$resourceStoreData->getByNo($info->resource_id);
                        $item['type']=$resourceTypeInfo->resource_filetype;
                        $item['text']=$name;
                        $item['url']=$resourceUrlInfo->filename;
                        $res[]=$item;
                    }
                }
            }
        }
        else
        {
            $res=null;
        }
        return $res;
    }
    /**
     * 通过模型id与图片名称获得url
     *
     * @param   $modelId 模型id
     * @param   $name   图片名称
     * @author  liu
     * @version 0.1
     * 
     * 修改返回null 改成 ''
     * @author  zhoutao
     * @date    2017.10.23
     */
    public function getUrl($modelId,$itemId,$name)
    {
        $model=$this->newitem();
        $resourceStoreData=new StoreItemInfoData();
        $resourceInfo=$model->where('resource_modelid', $modelId)->where('resource_itemno', $itemId)->where('resource_name', $name)->first();
        if($resourceInfo) {   
            $urlId=$resourceInfo->resource_id;
            $urlInfo=$resourceStoreData->newitem()->where('id', $urlId)->first();
            if($urlInfo) {
                $url=$urlInfo->filename;
            }
            else
            {
                $url='';
            }
        }
        else
        {
            $url='';
        }
        return $url;
    }

    public function getResource($resourceId,$dataId,$modelId)
    {
        $model=$this->newitem();
        $resourceTypeData=new ResourceTypeData();
        $typeInfo=$resourceTypeData->newitem()->where('resource_model_id', $modelId)->first();
        if(!$typeInfo) {
            return $this->error(902006);
        }
        $typeId=$typeInfo->id;
        $res=$model->where('resource_id', $resourceId)
            ->where('resource_typeid', $typeId)
            ->where('resource_itemno', $dataId)
            ->first();
        return $res;
    }
}
