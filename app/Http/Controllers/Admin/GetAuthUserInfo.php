<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\UserData;
use App\Http\Adapter\Auth\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetAuthUserInfo extends Controller
{
    /**
     * 查询管理员详细信息
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.2
     */
    public function run()
    {
        $data = new UserData();
        $adapter = new UserAdapter();
        $user = $data->get($this->session->userid);
        if ($user == null) {
            $this->Error(801002);
        }
        $res = $adapter->getDataContract($user);
        $this->Success($res);
    }
}
