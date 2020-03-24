<?php

namespace App\Http\Controllers\Kyc\Resource;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\File\PngUploadData;
use App\Data\File\DocUploadData;
use App\Data\File\JpgUploadData;
use App\Data\File\PdfUploadData;
use App\Data\File\JpegUploadData;
use App\System\Resource\Data\StoreItemInfoData;
use App\System\Resource\Data\ResourceIndexData;
use App\System\Resource\Data\ResourceTypeData;
use App\Data\Coin\CoinAddressInfoData;

/**
     * @api {post} auth/upload 上传图片
     * @apiName Upload
     * @apiGroup kyc
     * @apiVersion 0.0.1
     *
     * @apiParam {file} file  文件
     * @apiParam {int} coinuseraddress kyc用户地址
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      coinuserid : "1234",
     *      file : ""
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     * }
     */
class Upload extends Controller
{
    const COIN_MODEL_ID=3;
    const COIN_PIC_NAME="手持身份证照片";

    public function run()
    {
        $resourceIndexData=new ResourceIndexData;
        $storeInfoData=new StoreItemInfoData;
        $resourceTypeData=new ResourceTypeData;

        if (!$this->request->hasFile('file')) {
            return $this->Error(ErrorData::UPLOAD_FILE_EMPTY);
        }

        // $modelId=1;
        // $typeId=1;
        // dd($this->request->all());
        $modelId=self::COIN_MODEL_ID;
        $file = $this->request->file('file');
        $name=self::COIN_PIC_NAME;
        $itemAddress=$this->request->input('coinuseraddress');

        $coinAddressInfoData=new CoinAddressInfoData;
        $itemInfo=$coinAddressInfoData->newitem()->where('coin_address', $itemAddress)->first();
        $itemId=$itemInfo->id;

        $fileMime = $file->getClientMimeType();
        $handle = fopen($file, 'r');
        $base64 = base64_encode(fread($handle, filesize($file)));
        $base64File =  "data:{$fileMime};base64," . $base64;

        if (!$file->isValid()) {
            return $this->Error(ErrorData::UPLOAD_FILE_ERROR);
        }

        // 获取后缀
        $extension = $file->getClientOriginalExtension();
        $allowed_extensions = ["png", "jpg", "jpeg"];
        if (!$extension || !in_array($extension, $allowed_extensions)) {
            return $this->Error(ErrorData::UPLOAD_FILE_TYPE_ERROR);
        }
        $typeId=$resourceTypeData->GetIdByType($modelId, $name, $extension);

        // 验证文件大小是否合适
        if (!$file->getClientSize()) {
            return $this->Error(ErrorData::UPLOAD_FILE_SIZE_EMPTY);
        }
        if ($file->getClientSize() > $file->getMaxFilesize()) {
            return $this->Error(ErrorData::UPLOAD_FILE_SIZE_MAX);
        }
        
        // $modelName=$modelData->newitem()->where('id',$modelId)->first()->model_name;
        //移动图片
        $newName = microtime(true)*10000 . '.'.$extension;
        //根据配置与后缀分别存入指定文件夹
        $strUri = config('upload.file_dic') . '/'.$extension.'/';
        $file=$resourceTypeData->preHandle($file, $typeId);

        $file->move($strUri, $newName);
        //根据后缀选择（暂用）
        switch ($extension) {
        case 'png':
        {
            $uploadData=new PngUploadData;
            break;
}
        case 'jpg':
        {
            $uploadData=new JpgUploadData;
            break;
}
        case 'jpeg':
        {
            $uploadData=new JpegUploadData;
            break;
}
        default:
        {
            return $this->Error(ErrorData::UPLOAD_FILE_TYPE_ERROR);
                break;
}
        }
        $resourceId=$uploadData->add($strUri, $base64File);
        $resourceTypeData->postHandle($file, $typeId);

        $storeId=$storeInfoData->add($strUri.$newName, $resourceId, $extension);
        $resourceIndexData->add($typeId, $modelId, $storeId, $name, $itemId);

        return $this->Success($strUri.$newName);
    }
}
