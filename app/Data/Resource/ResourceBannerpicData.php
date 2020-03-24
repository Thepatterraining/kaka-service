<?php
namespace App\Data\Resource;
use App\Data\IDataFactory;
use App\System\Resource\Data\ResourceIndexData;
use App\System\Resource\Data\StoreItemInfoData;
use App\Data\Sys\ModelData;
use App\Http\Controllers\Resource\GetBanner;
use App\Data\Sys\ErrorData;

Class ResourceBannerpicData extends IDataFactory
{
    const WECHAT_BANNER_TYPE_INDEX=1;

    protected $modelclass="App\Model\Resource\ResourceBannerpic";

    /**
     * 添加轮播图资源信息
     *
     * @param   $resourceId 资源id
     * @param   $index 索引
     * @param   $modelDefineId 模型定义id
     * @param   $modelDefineTypeId 资源类型id   
     * @param   $resModelDefineId 关联模型定义id
     * @param   $resourceModelDataId 关联模型数据id
     * @param   $resUrl 关联链接
     * @param   $name 轮播图名称
     * @param   $level 展示优先级，最小为1，默认为1
     * @param   note 说明                                     $userid 用户id
     * @return  mixed
     * @author  liu
     * @version 0.1
     * @date    2017.11.8
     */
    public function add($resourceId,$index,$modelDefineId,$modelDefineDataId,$resModelDefineId,$resourceModelDataId,$resUrl,$name,$level,$note)
    {
        $model=$this->newitem();
        $modelData=new ModelData();
        $model->banner_resourceid=$resourceId;
        $model->banner_index=$index;
        $model->banner_model_define_id=$modelDefineId;

        $modelDefineInfo=$modelData->get($modelDefineId);
        $modelDefineName=$modelDefineInfo->model_name;
        $model->banner_model_define_name=$modelDefineName;

        $model->banner_model_define_data_id=$modelDefineDataId;

        $model->banner_res_model_define_id=$resModelDefineId;

        $resModelDefineInfo=$modelData->get($modelDefineId);
        $resModelDefineName=$resModelDefineInfo->model_name;
        $model->banner_res_model_define_name=$resModelDefineName;

        $model->banner_res_model_data_id=$resourceModelDataId;
        $model->banner_res_url=$resUrl;
        $model->banner_name=$name;
        $model->banner_show_level=$level;
        $model->banner_note=$note;

        $this->save($model);
    }

    /**
     * 修改轮播图资源信息
     *
     * @param   $id id
     * @param   $resourceId 资源id
     * @param   $index 索引
     * @param   $modelDefineId 模型定义id
     * @param   $modelDefineTypeId 资源类型id
     * @param   $resModelDefineId 关联模型定义id
     * @param   $resourceModelDataId 关联模型数据id
     * @param   $resUrl 关联链接
     * @param   $name 轮播图名称
     * @param   $level 展示优先级，最小为1，默认为1
     * @param   note 说明                                     $userid 用户id
     * @return  mixed
     * @author  liu
     * @version 0.1
     * @date    2017.11.8
     */
    public function changeBannerpic($id,$resourceId,$index,$modelDefineId,$modelDefineDataId,$resModelDefineId,$resourceModelDataId,$resUrl,$name,$level,$note)
    {
        $model=$this->newitem();
        $bannerInfo=$model->where('id', $id)->first();
        if(!$bannerInfo) {
            return $this->error(ErrorData::BANNER_NOT_EXIST);
        }
        $modelData=new ModelData();
        $bannerInfo->banner_resourceid=$resourceId;
        $bannerInfo->banner_index=$index;
        $bannerInfo->banner_model_define_id=$modelDefineId;

        $modelDefineInfo=$modelData->get($modelDefineId);
        $modelDefineName=$modelDefineInfo->model_name;
        $bannerInfo->banner_model_define_name=$modelDefineName;

        $bannerInfo->banner_model_define_data_id=$modelDefineDataId;

        $bannerInfo->banner_res_model_define_id=$resModelDefineId;

        $resModelDefineInfo=$modelData->get($modelDefineId);
        $resModelDefineName=$resModelDefineInfo->model_name;
        $bannerInfo->banner_res_model_define_name=$resModelDefineName;

        $bannerInfo->banner_res_model_data_id=$resourceModelDataId;
        $bannerInfo->banner_res_url=$resUrl;
        $bannerInfo->banner_name=$name;
        $bannerInfo->banner_show_level=$level;
        $bannerInfo->banner_note=$note;

        $this->save($bannerInfo);
    }
    /**
     * 获取轮播图资源信息
     *
     * @param   $index 轮播图索引
     * @return  mixed
     * @author  liu
     * @version 0.1
     * @date    2017.11.8
     */
    public function getBanner($index)
    {
        $model=$this->newitem();
        $banner=$model->orderBy('banner_show_level', 'desc')->orderBy('created_at', 'desc')->where('banner_index', $index)->get();
        if($banner->isEmpty()) {
            return $this->error(ErrorData::BANNER_NOT_EXIST);
        }
        $modelData=new ModelData();
        $resourceIndexData=new ResourceIndexData();
        $resourceStoreData=new StoreItemInfoData();
        foreach($banner as $bannerInfo)
        {
            $resourceId=$bannerInfo->banner_resourceid;
            $modelId=$bannerInfo->banner_model_define_id;
            $dataId=$bannerInfo->banner_model_define_data_id;

            $resStoreInfo=$resourceStoreData->get($resourceId);
            if(!$resStoreInfo) {
                return $this->error(ErrorData::RESOURCE_NOT_EXIST);
            }
        
            // if($modelId!=0)
            // {
            //     $modelInfo=$modelData->get($modelId);
            //         if(!$modelInfo)
            //         {
            //             return $this->error(ErrorData::MODEL_NOT_EXIST);
            //         }
                    
            //         $resInfo=$resourceIndexData->getResource($resourceId,$dataId,$modelId);
            //         if(!$resInfo)
            //         {
            //             return $this->error(ErrorData::BANNER_INDEX_NOT_EXIST);
            //         }
            //     }
            // }

            $item['loaction']=$resStoreInfo->filename;
            $resUrl=$bannerInfo->banner_res_url;
            if($resUrl) {
                $item['url']=$resUrl;
                $item['urlpart']=null;
            }
            else
            {
                $item['url']=null;
                $item['urlpart']['resdefineid']=$bannerInfo->banner_res_model_define_id;
                $item['urlpart']['resdefinename']=$bannerInfo->banner_res_model_define_name;
                $item['urlpart']['resdataid']=$bannerInfo->banner_res_model_data_id;
            }
            $res[]=$item;
        }
        return $res;
    }
    /**
     * 获取轮播图资源信息
     *
     * @param   $modelType 页面
     * @param   $index 轮播图索引
     * @return  mixed
     * @author  liu
     * @version 0.1
     * @date    2017.11.8
     */
    public function getBannerHandle($modelType,$addId)
    {
        $applicationData=new ApplicationData();
        $wechatApplicationInfo=$applicationData->newitem()->where('app_name', "微信")->first();
        $wechatAppId=$wechatApplicationInfo->app_id;
        if($modelType==GetBanner::MODEL_TYPE && $addId==$wechatAppId) {
            $index=WECHAT_BANNER_TYPE_INDEX;
            $this->getBanner($index);
        }
        return true;
    }
}   