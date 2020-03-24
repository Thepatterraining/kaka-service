<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Auth\UserData;
use App\Data\Sys\ErrorData;
use App\Data\Auth\LoginLogData;
use App\Data\Auth\AccessToken;

use App\Http\Adapter\Auth\UserAdapter;

class Login extends Controller
{
    //

    protected $validateArray=array(
        "userid"=>"required",
        "pwd"=>"required"
    );

    protected $validateMsg = [
        "userid.required"=>"请输入用户名",
        "pwd.required"=>"请输入密码"
    ];


    protected function run()
    {

        $userId = $this->request->input("userid");
        $pwd = $this->request->input("pwd");


        $logDataFac = new LoginLogData();


        $tokenFac = new AccessToken();
        $dataFac = new UserData();

        $user = $dataFac -> getUser($userId);

        if ($user==null) {
            $this->Error(ErrorData::$USER_NOT_FOUND);
            return;
        } else {
            $this->session->userid = $user->id;
            $loginResult = $dataFac->checkPwd($user, $pwd);
            
            if ($loginResult===true) {
                $user->auth_lastlogin = date("y-m-d H:i:s");
                $dataFac->save($user);
                $tokenFac->authAdminLogin($this->session->token, $user->id);
                $logDataFac->addLog();
                $adp = new UserAdapter();
                $info = $adp->getDataContract($user, null, true);
                $this->Success($info);
            } else {
                $this->Error(ErrorData::$USRR_PWD_WRONG);
            }
        }
    }
}
