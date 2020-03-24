<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\AccessToken;
use App\Data\User\UserData;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class Get3rdpayConfig extends Controller
{


    /**
     * 获取第三方支付配置
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.05.01
     */
    public function run()
    {
        // $data = new UserData();
        $res['open3rd'] =  true;
        $res['3rdSingleLimit'] = 10000;
        $res['rechargeSingleLimit'] = 10000;
        $res['recharge'] = false;
        return $this->Success($res);
    }
}
