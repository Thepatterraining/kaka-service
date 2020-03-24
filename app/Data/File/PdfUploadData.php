<?php
namespace App\Data\File;

use Illuminate\Support\Facades\DB;
use App\Data\IDataFactory;

class PdfUploadData extends IDatafactory
{

    protected $modelclass = 'App\Model\File\PdfUpload';

    protected $no = '_id';  

    /**
     * 上传文件，同时返回mongo id
     *
     * @param   $uri 文件存储位置
     * @param   $base64File 文件流
     * @author  liu
     * @version 0.1
     */
    public function add($uri, $base64File)
    {
        $model = $this->newitem();
        $model->uri = $uri;
        $model->base64 = $base64File;
        $model->save();
        return $model->_id; 
    }

    /**
     * 获取文件
     *
     * @param   $id mongo id字符串
     * @author  liu
     * @version 0.1
     */
    public function FindId($id)
    {
        $model = $this->newitem();
        $id=new \MongoDB\BSON\ObjectId($id);
        $res=$model->where('_id', $id)->first();  
        return $res;
    }
}
