<?php

namespace App\Http\Controllers\Wechat;

use App\Data\App\UserInfoData;
use App\Data\Sys\ErrorData;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Http\HttpLogic\UserLogic;
use App\Data\Sys\LoginLogData;

class AppLogin extends Controller
{

    protected $validateArray=[
        "openid"=>"required",
        "appid"=>"required",
        "phone"=>"required",
        "verify"=>"required",
    ];

    protected $validateMsg = [
        "openid.required"=>"请输入openid!",
        "appid.required"=>"请输入appid!",
        "phone.required"=>"请输入手机号!",
        "verify.required"=>"请输入验证码!",
    ];

    /**
     * 微信手机验证 登陆
     *
     * @param   $openid
     * @param   $appid
     * @param   $phone
     * @param   $verify
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.14
     */
    public function run()
    {
        $request = $this->request->all();
        $phone = $request['phone'];
        $verify = $request['verify'];
        $openid = $request['openid'];
        $appid = $request['appid'];

        //验证验证码
        $sendSms = new SendSmsData();
        $smsRes = $sendSms->isVerfyCode($phone, $verify);
        if ($smsRes === false) {
            // return $this->Error(ErrorData::$VERIFY_FALSE);
        }

        $res = [];
        $userInfoData = new UserInfoData();
        $res = $userInfoData->appLogin($appid, $openid, $phone);

        if (empty($res)) {
            return $this->Error(ErrorData::$USER_NOT_FOUND);
        }

        $adapter = new UserAdapter();
        $userData = new UserData();
        if (count($res) > 0) {
            $res = $adapter->getDataContract($res);
            
            $userLogic = new UserLogic;
            $res = $userLogic->getUser($res);
        }

        $logDataFac = new LoginLogData();
        $logDataFac->addLog();
            

        return $this->Success($res);
    }
}
