<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;

class RegProfile extends Controller
{

    /**
     * 获取邀请码长度和是否使用
     *
     * @author zhoutao
     */
    public function run()
    {
        $data = new UserData();
        $codeRes = $data->getSysCoinfigReq();

        return $this->Success($codeRes);
    }
}
