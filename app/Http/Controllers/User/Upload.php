<?php

namespace App\Http\Controllers\User;

use App\Data\Sys\SendSmsData;
use App\Data\User\BankAccountData;
use App\Data\User\UserBankCardData;
use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\ErrorData;
use Illuminate\Support\Facades\Storage;
use App\Data\File\UploadData;

class Upload extends Controller
{

    public function run()
    {
        if (!$this->request->hasFile('file')) {
            return $this->Error(ErrorData::UPLOAD_FILE_EMPTY);
        }

        $file = $this->request->file('file');
        $fileMime = $file->getClientMimeType();
        $handle = fopen($file, 'r');
        $base64 = base64_encode(fread($handle, filesize($file)));
        $base64File =  "data:{$fileMime};base64," . $base64;

        if (!$file->isValid()) {
            return $this->Error(ErrorData::UPLOAD_FILE_ERROR);
        }

        // 获取后缀
        $extension = $file->getClientOriginalExtension();
        $allowed_extensions = ["png", "jpg", "gif", "pdf", "txt"];
        if ($extension && !in_array($extension, $allowed_extensions)) {
            return $this->Error(ErrorData::UPLOAD_FILE_TYPE_ERROR);
        }

        // 验证文件大小是否合适
        if(!$file->getClientSize() ) {
            return $this->Error(ErrorData::UPLOAD_FILE_SIZE_EMPTY);
        }
        if($file->getClientSize() > $file->getMaxFilesize() ) {
            return $this->Error(ErrorData::UPLOAD_FILE_SIZE_MAX);
        }

        //移动图片
        $newName = microtime(true)*10000 . '.'.$extension;  
        // $strUri = env('IMG_URL').'/' . date('Ymd') . '/';
        // if (!is_dir($strUri)) {
            // mkdir($strUri);
        // }
        $strUri = config('upload.file_dic') . '/';
        $file->move($strUri, $newName);
        // Storage::put('base4.pdf',base64_decode($base64));

        $uploadData = new UploadData;
        $uploadData->add($strUri.$newName, $base64File);

        return $this->Success($strUri . $newName);
    }
}
