<?php

namespace App\Http\Controllers\Wechat;

use App\Data\App\UserInfoData;
use App\Data\User\UserData;
use App\Http\Adapter\App\UserInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetUserInfo extends Controller
{
    protected $validateArray=[
        "userid"=>"required_without_all:openid,unionid",
        "openid"=>"required_without_all:userid,unionid",
        "unionid"=>"required_without_all:userid,openid",
        "appid"=>"required",
    ];

    protected $validateMsg = [
        "userid.required"=>"请输入用户id!",
        "userid.required_without"=>"请输入用户id!",
        "openid.required_without"=>"请输入openid!",
        "appid.required"=>"请输入appid!",
    ];

    /**
     * 使用appid 和 userid 查询微信用户信息
     *
     * @param   $appid
     * @param   $userid
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.20
     */
    public function run()
    {
        $adapter = new UserInfoAdapter();
        $data = new UserInfoData();
        $userData = new UserData();

        $request = $this->request->all();
        $appid = $request['appid'];

        if ($this->request->has('unionid')) {
            $unionid = $request['unionid'];
            $userInfo = $data->getUserWhereUnion($unionid);
        } elseif ($this->request->has('userid')) {
            $userid = $request['userid'];
            $userInfo = $data->getUserInfo($userid, $appid);
        } elseif ($this->request->has('openid')) {
            $openid = $request['openid'];
            $userInfo = $data->getInfo($appid, $openid);
        }

        $res = [];
        if ($userInfo != null) {
            $arr = $adapter->getDataContract($userInfo);
            $arr['userInfo'] = $userData->getUser($arr['kkuserid']);
            $res = $arr;
        }

        return $this->Success($res);
    }
}
