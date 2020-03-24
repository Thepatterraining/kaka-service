<?php
namespace App\Data\App;

use App\Data\Auth\AccessToken;
use App\Data\IDataFactory;
use App\Data\User\UserData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\App\UserInfoAdapter;
// use App\Data\Notify\INotifyDefault;
use App\Data\Lending\LendingUserData;
use App\Data\Frozen\FrozenFactory;
use App\Data\Coin\FrozenData;
use App\Data\User\CoinAccountData as UserCoinAccountData;

class UserInfoData extends IDatafactory
{
    protected $modelclass = 'App\Model\App\UserInfo';

    const SYSCOIN_TOUSER_EVENT_TYPE = 'sysCoin_toUser_Check';
    const BINDING_TYPE='first_bind';

    /**
     * 查询第三方用户信息
     *
     * @param   int $appid appid
     * @param   int $openid openid
     * @return  object $info
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.13
     */
    public function getInfo($appid, $openid)
    {
        $where['appid'] = $appid;
        $where['openid'] = $openid;

        $model = $this->newitem();
        $info = $model->where($where)->first();
        return $info;
    }

    /**
     * 查询是否绑定用户
     *
     * @param   $appid
     * @param   $openid
     * @return  null
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.13
     */
    public function isBind($appid, $openid)
    {
        $where['appid'] = $appid;
        $where['openid'] = $openid;

        $model = $this->newitem();
        $info = $model->where($where)->first();
        if ($info == null) {
            return false;
        }
        if ($info->kkuserid > 0) {
            $userData = new UserData;
            $user = $userData->get($info->kkuserid);
            if (!empty($user)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 微信绑定后登陆
     *
     * @param   $userid 用户id
     * @return  array
     * @author  zhoutao
     * @version 0,1
     * @date    2017.4.13
     */
    public function login($appid, $openid)
    {
        $userInfo = $this->getInfo($appid, $openid);
        $userid = $userInfo->kkuserid;

        $tokenFac = new AccessToken();

        $token = $this->session->token;
        $this->session->userid = $userid;
        $tokenFac->updateAccessToken($token, $userid);

        $userData = new UserData();
        $userInfo = $userData->get($userid);
        if ($userInfo == null) {
            return [];
        }
        $userData->updateLastLoginTime($userid);
        return $userInfo;
    }

    /**
     * 添加第三方用户
     *
     * @param   $model model
     * @param   $appid appid
     * @param   $openid openid
     * @param   $userid userid
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.13
     * 增加绑定时间
     * @author  zhoutao
     * @date    2017.11.10
     */
    public function add($model, $appid, $openid, $userid)
    {
        $model->appid = $appid;
        $model->openid = $openid;
        $model->kkuserid = $userid;
        $res = $this->create($model);
        return $res;
    }

    /**
     * 进行验证登陆
     *
     * @param   $appid appid
     * @param   $openid openid
     * @param   $phone 手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.14
     * 增加绑定时间
     * @author  zhoutao
     * @date    2017.11.10
     */
    public function appLogin($appid, $openid, $phone)
    {
        $adapter = new UserInfoAdapter();
        $tokenFac = new AccessToken();
        $userData = new UserData();

        $appInfo = $this->getInfo($appid, $openid);

        $userInfo = $userData->getUser($phone);
        if ($userInfo == null) {
            return [];
        }
        $userid = $userInfo->id;
        $this->session->userid = $userid;

        $where['kkuserid'] = $userid;
        $where['appid'] = $appid;
        $model = $this->newitem();
        $appUserInfo = $model->where($where)->first();
        if ($appUserInfo == null) {
            //查询 openid 和 appid
            $appInfo->kkuserid = $userid;
            $appInfo->binding_time = date('Y-m-d H:i:s');
            $this->save($appInfo);
        } else {
            //已经绑定，查询是否正确
            if ($appUserInfo->openid != $openid) {
                //更新 openid
                $appUserInfo->kkuserid = 0;
                $this->save($appUserInfo);
                
                $appInfo->kkuserid = $userid;
                $this->save($appInfo);
            }
        }

        //登陆 返回用户信息
        $token = $this->session->token;
        $tokenFac->updateAccessToken($token, $userid);

        return $userInfo;
    }

    /**
     * 根据用户id 和 appid 查询微信用户信息
     *
     * @param   $userid
     * @param   $appid
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.20
     */
    public function getUserInfo($userid, $appid)
    {
        $where['kkuserid'] = $userid;
        $where['appid'] = $appid;
        $info = $this->find($where);
        return $info;
    }
    
    /**
     * 根据unionid 查询微信用户信息
     *
     * @param   $unionid
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.25
     */
    public function getUserWhereUnion($unionid)
    {
        $where['unionid'] = $unionid;
        $info = $this->find($where);
        return $info;
    }

    /**
     * 根据unionid 查询微信用户信息
     *
     * @param   $unionid
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.25
     */
    public function getUser($unionid, $appid, $openid)
    {
        $where['unionid'] = $unionid;
        $where['appid'] = $appid;
        $where['openid'] = $openid;
        $info = $this->find($where);
        return $info;
    }

    /**
     * 根据appid 和 openid 查询用户信息 更新该用户的unionid
     *
     * @param   $appid
     * @param   $openid
     * @param   $unionid
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.25
     */
    public function saveUserUnion($appid, $openid, $unionid)
    {
        $userInfo = $this->getInfo($appid, $openid);
        $userInfo->unionid = $unionid;
        return $this->save($userInfo);
    }

    /**
     * 查询unionid 的所有数据
     *
     * @param   $unionid
     * @author  zhoutao
     * @version 0.1
     */
    public function getUsersWhereUnionid($unionid)
    {
        $where['unionid'] = $unionid;
        $model = $this->modelclass;
        return $model::where($where)->get();
    }

    /**
     * 更新用户kkuserid
     *
     * @param   $openid openid
     * @param   $appid appid
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function saveUserid($appid, $openid, $userid)
    {
        $userInfo = $this->getInfo($appid, $openid);
        $userInfo->kkuserid = $userid;
        $userInfo->binding_time = date('Y-m-d H:i:s');
        $this->save($userInfo);
    }

    /**
     * 根据userid查到相关微信用户信息
     *
     * @param   $userid 用户id
     * @author  liu
     * @version 0.1
     */
    public function getByUserid($userid, $appid)
    {
        $where['kkuserid'] = $userid;
        $where['appid']=$appid;
        $model = $this->modelclass;
        return $model::where($where)->first();
    }

    /**
     * 查询这个用户绑定的微信信息
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.11.13
     */
    public function getUserByUserid($userid)
    {
        $where['kkuserid'] = $userid;
        $model = $this->modelclass;
        return $model::where($where)->first();
    }
}
