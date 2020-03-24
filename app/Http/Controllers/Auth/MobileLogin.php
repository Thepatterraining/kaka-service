<?php

namespace App\Http\Controllers\Auth;

use App\Data\Sys\SendSmsData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Data\Sys\ErrorData;
use App\Data\Sys\LoginLogData;
use App\Data\Auth\AccessToken;
use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Http\HttpLogic\UserLogic;


class MobileLogin extends Controller
{
    //

    protected $validateArray=array(
        "phone"=>"required",
        "verify"=>"required"
    );

    protected $validateMsg = [
        "phone.required"=>"请输入手机号",
        "verify.required"=>"请输入验证码"
    ];


    protected function run()
    {

        $phone = $this->request->input('phone');
        $verify = $this->request->input('verify');

        $logDataFac = new LoginLogData();


        $tokenFac = new AccessToken();
        $dataFac = new UserData();

        $user = $dataFac -> getUser($phone);


        if ($user == null) {
            return $this->Error(ErrorData::$USER_NOT_FOUND);
        } else {
            $user->user_lastlogin = date("y-m-d H:i:s");
            $dataFac->save($user);
            $this->session->userid = $user->id;
            $tokenFac-> updateAccessToken(
                $this->session->token, $user->id
            );
            $logDataFac->addLog();
            $adp = new UserAdapter();
            $info = $adp->getDataContract($user, null, true);

            $userLogic = new UserLogic;
            $info = $userLogic->getUser($info);
            
            return $this->Success($info);
        }
    }
}
