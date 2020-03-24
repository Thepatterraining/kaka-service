<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\File\PngUploadData;
use App\Data\File\PdfUploadData;
use App\Data\File\JpgUploadData;
use App\Data\File\DocUploadData;
use App\System\Resource\Data\ResourceTypeData;

use mongo;
/**
 * 下载
 */
class Download extends Controller
{
    /**
     * 调用
     */
    public function run()
    {
        $type = $this->request->input('type');
        $url = $this->request->input('url');

        $resourceTypeData=new ResourceTypeData;
        $resourceTypeInfo=$resourceTypeData->newitem()->where('filename', $url)->first();
        $fileid=$resourceTypeInfo->storeid;
        switch($type)
        {
        case 'png':
            $uploadData=new PngUploadData;
            break;
        case 'jpg':
            $uploadData=new JpgUploadData;
            break;
        case 'pdf':
            $uploadData=new PdfUploadData;
            break;
        case 'doc':
            $uploadData=new DocUploadData;
            break;
        default:
            return $this->Error(ErrorData::UPLOAD_FILE_TYPE_ERROR);
        }
        $res = $uploadData->FindId($fileid);
        return $this->Success($res);
    }
}
