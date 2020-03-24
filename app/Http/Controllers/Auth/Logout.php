<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
//use App\Http\Adapter\userAdapter;
use App\Data\Sys\ErrorData;

class Logout extends Controller
{
    //
    protected function run()
    {

        $adapter = new UserAdapter;
        $fac = new UserData();
        
        $item = $fac->get(1);
        $result = $adapter->getDataContract($item, array("loginid","name","nickname","headimgurl"));
        
        //$this->Success($result);
        $this->Error(ErrorData::$USER_NOT_FOUND);
    }
}
