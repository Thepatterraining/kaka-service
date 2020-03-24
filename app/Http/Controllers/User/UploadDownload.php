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

class UploadDownload extends Controller
{

    public function run()
    {
        $userid = $this->request->input('userid');
        $fileid = $this->request->input('imgId');

        if ($this->session->userid != $userid) {
            return $this->Error(902008);
        }
        $uploadData = new UploadData;
        $res = $uploadData->getByNo($fileid);
        
        return $this->Success($res);
    }
}
