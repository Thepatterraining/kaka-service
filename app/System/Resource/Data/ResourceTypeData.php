<?php 
namespace App\System\Resource\Data;
use App\Data\IDataFactory;
use App\Data\Project\ProjectInfoData;

class ResourceTypeData extends IDataFactory
{
    
    protected $modelclass="App\System\Resource\Model\ResourceType";

    /**
     * 前置处理
     *
     * @param   $file 文件
     * @param   $typeId 类型id
     * @author  liu
     * @version 0.1
     */
    public function preHandle($file,$typeId)
    {
        $model=$this->newitem();
        $res=$model->where('id', $typeId)->first();
        //前置处理类判空
        if($res->resource_pre_logic!=null) {
            $preModel=$res->resource_pre_logic;
            //前置处理参数判空
            if($res->resource_pre_param!=null) {
                $jobClass=new $preModel($res->resource_pre_param);
                $file=$jobClass->perHandle($file);
            }
            else
            {
                $jobClass=new $preModel();
                $file=$jobClass->perHandle($file);
            }
        }
        return $file;
    }
    /**
     * 后置处理
     *
     * @param   $file 文件
     * @param   $typeId 类型id
     * @author  liu
     * @version 0.1
     */
    public function postHandle($file,$typeId)
    {
        $model=$this->newitem();
        $res=$model->where('id', $typeId)->first();
        //前置处理类判空
        if($res->resource_post_logic!=null) {
            $postModel=$res->resource_post_logic;
            //前置处理参数判空
            if($res->resource_post_param!=null) {
                $jobClass=new $postModel($res->resource_post_param);
                $file=$jobClass->postHandle($file);
            }
            else
            {
                $jobClass=new $postModel();
                $file=$jobClass->postHandle($file);
            }
        }
        return $file;
    }
    /**
     * 通过id获取存储信息
     *
     * @param   $id 
     * @author  liu
     * @version 0.1
     */
    public function GetById($id)
    {
        $model=$this->newitem();
        $res=$model->where('id', $id)->first();
        return $res;
    }
    /**
     * 通过文件后缀，文件类型名称与相关项目获取存储信息
     *
     * @param   $modelid    项目id
     * @param   $typeName   文件类型名称 
     * @param   $extension  文件后缀
     * @author  liu
     * @version 0.1
     */
    public function GetIdByType($modelid,$typeName,$extension)
    {
        $model=$this->newitem();
        $res=$model->where('resource_model_id', $modelid)->where('resource_type_name', $typeName)->where('resource_filetype', $extension)->first();
        return $res->id;
    }
     /**
      * 添加类型信息
      *
      * @param   $typeName 类型id
      * @param   $modelId 模型id
      * @param   $fileType 存储id
      * @param   $preLogic 前置处理类
      * @param   $preParam 前置处理参数
      * @param   $postLogic 后置处理类
      * @param   $postParam 后置处理类
      * @param   $name  资源所属类别名称
      * @author  liu
      * @version 0.1
      */
    public function add($modelId,$typeName,$fileType,$preLogic=null,$preParam=null,$postLogic=null,$postParam=null)
    {
        $model=$this->newitem();
        $projectInfoData=new ProjectInfoData();
        $projectInfo=$projectInfoData->newitem()->where('id', $modelId)->first();
        if(!$projectInfo) {
            return false;
        }

        $model->resource_type_name=$typeName;
        $model->resource_filetype=$fileType;
        $model->resource_model_id=$modelId;
        $model->resource_model_name=$projectInfo->project_name;
        $model->resource_pre_logic=$preLogic;
        $model->resource_pre_param=$preParam;
        $model->resource_post_logic=$postLogic;
        $model->resource_post_param=$postParam;
        $model->save();
    }
    /**
     * 更新类型信息
     *
     * @param   $id id
     * @param   $typeName 类型id
     * @param   $modelId 模型id
     * @param   $fileType 存储id
     * @param   $preLogic 前置处理类
     * @param   $preParam 前置处理参数
     * @param   $postLogic 后置处理类
     * @param   $postParam 后置处理类
     * @param   $name  资源所属类别名称
     * @author  liu
     * @version 0.1
     */
    public function updateType($id,$modelId,$typeName,$fileType,$preLogic=null,$preParam=null,$postLogic=null,$postParam=null)
    {
        $model=$this->newitem();
        $projectInfoData=new ProjectInfoData();
        $projectInfo=$projectInfoData->newitem()->where('id', $modelId)->first();
        if(!$projectInfo) {
            return false;
        }
        $res=$model->where('id', $id)->first();
        if($res) {
            $res->resource_type_name=$typeName;
            $res->resource_filetype=$fileType;
            $res->resource_model_id=$modelId;
            $res->resource_model_name=$projectInfo->project_name;
            $res->resource_pre_logic=$preLogic;
            $res->resource_pre_param=$preParam;
            $res->resource_post_logic=$postLogic;
            $res->resource_post_param=$postParam;
            $res->save();
        }
    }
}