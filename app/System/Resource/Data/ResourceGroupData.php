<?php 
namespace App\System\Resource\Data;
use App\Data\IDataFactory;

class ResourceGroupData extends IDataFactory
{
    protected $modelclass="App\System\Resource\Model\ResourceGroup";

    /**
     * 添加组别信息
     *
     * @param   $modelId 模型id
     * @param   $groupName  组别名称
     * @param   $groupInclude 组别包含资源
     * @author  liu
     * @version 0.1
     */
    public function add($modelId,$groupName,$groupInclude,$groupLevel)
    {
        $model=$this->newitem();
        $model->resource_modelid=$modelId;
        $model->resource_group=$groupName;
        $model->resource_group_include=$groupInclude;
        $model->resouece_group_level=$groupLevel;
        $model->save();
    }

    /**
     * 更新组别信息
     *
     * @param   $id id
     * @param   $modelId 模型id
     * @param   $groupName  组别名称
     * @param   $groupInclude 组别包含资源
     * @author  liu
     * @version 0.1
     */
    public function updateGroup($id,$modelId,$groupName,$groupInclude)
    {
        $model=$this->newitem();
        $res=$model->where('id', $id)->first();
        if($res) {
            $res->resource_modelid=$modelId;
            $res->resource_group=$groupName;
            $res->resource_group_include=$groupInclude;
            $model->resouece_group_level=$groupLevel;
            $res->save();
        }
    }
    /**
     * 通过模型id获得索引信息
     *
     * @param   $modelId 模型id
     * @author  liu
     * @version 0.1
     */
    public function getResourceId($modelId)
    {
        $model=$this->newitem();
        $res=$model->where('resource_modelid', $modelId)->get();
        return $res;
    }
    /**
     * 获取资源详情
     *
     * @param   $modelId 模型id
     * @param   $itemId  相关项目id
     * @author  liu
     * @version 0.1
     */
    public function getResourceItem($modelId,$itemId)
    {
        $model=$this->newitem();
        $resourceIndexData=new ResourceIndexData();
        $groupInfo=$model->orderBy('resource_group_level', 'asc')->where('resource_model_id', $modelId)->get();
        $i=0;
        $res=array();
        if(!$groupInfo->isEmpty()) {
            foreach($groupInfo as $group)
            {   
                $groupName=$group->resource_group;
                $res[$i]['group']=$groupName;
                $res[$i]['items']=$resourceIndexData->getItem($modelId, $itemId, $group->resource_group_include);
                if(!$res[$i]['items']) {
                    $res[$i]['group']=null;
                }
                else
                {
                    $i++;
                }                    
            }
        }
        else
        {
            $res=null;
        }
        return $res;
    }
}