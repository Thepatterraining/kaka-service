<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\AccessToken;
use App\Data\User\UserData;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class GetCode extends Controller
{


    /**
     * 获取验证码
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.05.01
     */
    public function run()
    {
        $data = new UserData();
        $base64Image = $data->getLoginCode();
        return $this->Success($base64Image);
    }
}
