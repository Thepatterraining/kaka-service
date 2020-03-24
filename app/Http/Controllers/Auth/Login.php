<?php

namespace App\Http\Controllers\Auth;

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

class Login extends Controller
{
    //

    protected $validateArray=array(
        "userid"=>"required",
        "pwd"=>"required",
        "code"=>"required"
    );

    protected $validateMsg = [
        "userid.*"=>"请输入用户名",
        "code.required"=>"请输入验证码",
        "pwd.required"=>"请输入登陆密码",
    ];


    protected function run()
    {

        $userId = $this->request->input("userid");
        $pwd = $this->request->input("pwd");
        $code = $this->request->input("code");
         
        $logDataFac = new LoginLogData();

    
        $tokenFac = new AccessToken();
        $dataFac = new UserData();

        //判断图形验证码是否正确
        if ($dataFac->checkLoginCode($code) === false) {
            return $this->Error(ErrorData::IMG_CODE_ERROR);
        }

        $user = $dataFac -> getUser($userId);


        if ($user==null) {
            $this->Error(ErrorData::$USER_NOT_FOUND);
            return;
        } else {
            $this->session->userid = $user->id;
            $loginResult = $dataFac->checkPwd($user, $pwd);
            if ($loginResult===true) {
                $user->user_lastlogin = date("y-m-d H:i:s");
                $dataFac->save($user);
                $tokenFac-> updateAccessToken(
                    $this->session->token, $this->session->userid
                );
                $logDataFac->addLog();
                $adp = new UserAdapter();
                $info = $adp->getDataContract($user, null, true);
                
                $userLogic = new UserLogic;
                $info = $userLogic->getUser($info);
                $this->Success($info);
            } else {
                $this->Error(ErrorData::$USRR_PWD_WRONG);
            }
        }
    }
}
