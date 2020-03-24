<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Auth\AccessToken;
use App\Data\Sys\LoginLogData;
use App\Data\Sys\ApplicationData;
use App\Data\Sys\ErrorData;

class RequireTokenController extends Controller
{

    private $_appid = 'F3452E02-AE64-A825-8C29-DFE5B2EA9C57';
    private $_appSecrect = '9F7huqSentmOWddT';

    protected $validateArray=array(
        // "appid"=>"required",
        // "appSecrect"=>"required",
    );

    protected $validateMsg = [
        "appid.required"=>"请输入appid",
        "appSecrect.required"=>"请输入appSecrect",
    ];
    //
    protected function run()
    {
        $appid = $this->_appid;
        if ($this->request->has('appid')) {
            $appid = $this->request->input('appid');
        }
        $appSecrect = $this->_appSecrect;
        if ($this->request->has('appSecrect')) {
            $appSecrect = $this->request->input('appSecrect');
        }

        //验证appSecrect
        $applicationData = new ApplicationData;
        if ($applicationData->checkAppSecrect($appid, $appSecrect) === false) {
            return $this->Error(ErrorData::APP_KEY_ERROR);
        }

        $timeout = 60*60*2;
        $accessData = new AccessToken(0, $timeout);

        $appInfo = $applicationData->getByNo($appid);
        $app['appid'] = $appInfo->app_id;
        $app['appName'] = $appInfo->app_name;
        $app['userid'] = 0;
        $this->session->appid = $app['appid'];
        $this->session->appName = $app['appName'];
        $token = $accessData->getAccessToken($app);
        $this->session->token = $token;
        $loginLogData = new LoginLogData;
        $loginLogData->createLog($appid);
        $this->Success(
            array(
                "timeout"=>$timeout,
                "accessToken"=>$token
 
            )
        );
    }
}
