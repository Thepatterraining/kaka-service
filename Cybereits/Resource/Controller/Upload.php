<?php
namespace Cybereits\Resource\Controller;

use Cybereits\Http\IController;
use Cybereits\Resource\Data\ResourceMongoStoreData;
use Storage;

/**
 * 上传
 */
class Upload extends IController
{
    protected function run($param)
    {
        $this->request->file('file');
 
        $input = $this->request->file('file');
        $name = $input->store("tmp");
 
        $data = new ResourceMongoStoreData();
        $file_name = $file = Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($name);
        dump($file_name);
        $fileid = $data->StoreFile($file_name, [""]);
        $this->Success(['file_id'=>$fileid]);
    }
}
