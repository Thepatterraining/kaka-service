<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;

class ModelData extends IDatafactory
{

    protected $modelclass = 'App\Model\Sys\Model';
    const PROJECT_MODEL='MO01';
    /**
     * 添加索引信息
     *
     * @param   $modelName 模型名称
     * @param   $modelClass 类名
     * @param   $modelFilename 文件名
     * @param   $modelTable 表名
     * @param   $modelVersion 版本号
     * @author  liu
     * @version 0.1
     */
    public function add($modelName,$modelClass,$modelFilename=null,$modelTable,$modelVersion=null)
    {
        $model=$this->newitem();
        $model->model_name=$modelName;
        $model->model_class=$modelClass;
        $model->model_filename=$modelFilename;
        $model->model_table=$modelTable;
        $model->model_version=$modelVersion;
        $model->save();
    }   

    /**
     * 通过模型名称获得模型id
     *
     * @param   $modelName 模型名称
     * @author  liu
     * @version 0.1
     */
    public function getModelId($modelName)
    {
        $model=$this->newitem();
        $res=$model->where('model_name', $modelName)->first();
        if(!empty($res)) {
            return $res->id;
        }
        else
        {
            return null;
        }
    }
    /**
     * 通过模型获得模型id
     *
     * @param   $modelInfo 模型
     * @author  liu
     * @version 0.1
     */
    public function getModelIdByModel($modelInfo)
    {
        $model=$this->newitem();
        $modelName=get_class($modelInfo);
        if(get_parent_class($modelName)=='Illuminate\\Database\\Eloquent\\Model') {
            $res=$model->where('model_class', $modelName)->first();
            if(!empty($res)) {
                return $res->id;
            }
        }
        return null;
    }
}