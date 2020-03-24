<?php
namespace Cybereits\Resource\Controller;

use Cybereits\Http\IController;
use Cybereits\Resource\Data\ResourceMongoStoreData;

/**
 * 得到资源
 * @author 老拐 <geyunfei@kakamf.com>
 * @date Feb 28th,2018
 * @version 0.1
 */
class GetResource extends IController
{
    protected $json = false ;
    private $_fileid = "";

    /***
     * 重载
     * @param id 资源id
     */
    protected function run($id)
    {
        if (is_array($id) && count($id)>0) {
            $this->_fileid = $id[0];
        }
    }
    /**
     * 重载得到结果的方法
     */
    public function GetResult()
    {
        $fac = new ResourceMongoStoreData();
        $fileid = $this->_fileid;
        $fun = function () use ($fac,$fileid) {
            $res = $fac->GetFile($fileid);
            header("Content-type: ".$res-> content_type);
            echo $res->stream;
        };
        return response()-> stream(
            $fun,
            200,
            []
        );
    }
}
