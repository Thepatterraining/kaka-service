<?php

namespace App\Http\Controllers\Admin;

use App\Data\Item\InfoData;
use App\Data\Sys\DictionaryData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Data\Activity\GroupData;
use App\Http\Adapter\Activity\GroupAdapter;
use App\Data\Auth\AuthGroupData;
use App\Http\Adapter\Auth\AuthGroupAdapter;
use App\Data\Activity\InvitationCodeData;
use App\Http\Adapter\Activity\InvitationCodeAdapter;
use App\Data\Sys\ErrorData;

class CodeGetUser extends Controller
{

    protected $validateArray=[
        "code"=>"required",
    ];

    protected $validateMsg = [
        "code.required"=>"请输入邀请码",
    ];

    /**
     * 使用邀请码查询用户信息
     *
     * @param $code 邀请码
     */
    public function run()
    {
        $code = $this->request->input('code');

        $data = new InvitationCodeData;
        $userData = new UserData;
        $userAdapter = new UserAdapter;
        $user = $data->getCodeUserInfo($code);

        if (!is_array($user)) {
            return $this->Error($user);
        }

        return $this->Success($user);
    }
}
