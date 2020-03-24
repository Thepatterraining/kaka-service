<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Auth\AccessToken;

class RequireTokenController extends Controller
{
    //
    protected function run()
    {


        $timeout = 7200;
        $accessData = new AccessToken(0, $timeout);

        $token = $accessData->getAdminAccessToken();
        $this->session->token = $token;
        $this->Success(
            array(
                "timeout"=>$timeout,
                "accessToken"=>$token
            )
        );
    }
}
