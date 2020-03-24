<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\AccessToken;
use App\Data\User\UserData;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Data\User\BankAccountData;
use App\Data\Sys\ErrorData;
use App\Http\HttpLogic\UserLogic;

class GetUser extends Controller
{


    /**
     * 使用token 获取用户信息
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $token = $this->request->input('accessToken');
        $tokenFac = new AccessToken;
        $userid = $tokenFac->checkAccessToken($token);

        if (empty($userid["userid"])) {
            return $this->Success();
        }
        $this->session->userid = $userid["userid"];
        $data = new UserData();
        $adapter = new UserAdapter;
        $user = $data->get($userid["userid"]);
        
        if (empty($user)) {
            return $this->Error(ErrorData::$USER_NOT_FOUND);
        }

        $user = $adapter->getDataContract($user);
            
        $userLogic = new UserLogic;
        $user = $userLogic->getUser($user);

        return $this->Success($user);
        
        
    }
}
