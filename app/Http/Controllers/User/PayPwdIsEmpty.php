<?php

namespace App\Http\Controllers\User;

use App\Data\User\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayPwdIsEmpty extends Controller
{
    protected function run()
    {
        $data = new UserData();

        $paypwdIsEmpty = $data->paypwdIsEmpty();

        // if ($res == true && $res !== true) {
        //     return $this->Error($res);
        // } else {
        //     return $this->Success($res);
        // }
        if ($paypwdIsEmpty === 0 || $paypwdIsEmpty === 1) {
            return $this->Success($paypwdIsEmpty);
        } elseif ($paypwdIsEmpty == true && $paypwdIsEmpty !== true) {
            return $this->Error($paypwdIsEmpty);
        }
    }
}
