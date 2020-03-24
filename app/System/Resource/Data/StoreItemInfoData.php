<?php 
namespace App\System\Resource\Data;
use App\Data\IDataFactory;

class StoreItemInfoData extends IDataFactory
{
    
    protected $modelclass="App\System\Resource\Model\StoreItemInfo";

    /**
     * 添加存储信息
     *
     * @param   $fileName 文件名
     * @param   $storeId 外部存储id
     * @param   $fileType 文件类型
     * @author  liu
     * @version 0.1
     */
    public function add($fileName,$storeId,$fileType)
    {
        $model=$this->newitem();
        $model->filename=$fileName;
        $model->storeid=$storeId;
        $model->filetype=$fileType;
        $model->save();
        return $model->id;
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
        // dump($res);
        return $res;
    }
}