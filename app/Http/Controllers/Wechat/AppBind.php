<?php

namespace App\Http\Controllers\Wechat;

use App\Data\App\AppInfoData;
use App\Data\App\UserInfoData;
use App\Data\Sys\ErrorData;
use App\Http\Adapter\App\UserInfoAdapter;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\User\UserData;
use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Http\HttpLogic\UserLogic;
use App\Data\Sys\LoginLogData;

class AppBind extends Controller
{
    protected $validateArray=[
        "openid"=>"required",
        "appid"=>"required",
        "data"=>"required|array",
    ];

    protected $validateMsg = [
        "openid.required"=>"请输入openid!",
        "appid.required"=>"请输入appid!",
        "data.required"=>"请输入data!",
        "data.array"=>"data必须是数组!",
    ];

    /**
     * @api {post} wechat/appbind 微信绑定接口
     * @apiName 微信绑定接口
     * @apiGroup Wechat
     * @apiVersion 0.0.1
     *
     * @apiParam {string} openid openid
     * @apiParam {string} appid appid
     * @apiParam {array} data 用户参数
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      openid : openid,
     *      appid  : appid,
     *      data   : {
     *          unionid : unionid,...
     *      }
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *  {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {},...
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $openid = $request['openid'];
        $appid = $request['appid'];

        $data = new UserInfoData();
        $adapter = new UserInfoAdapter();
        $userAdapter = new UserAdapter();
        $userData = new UserData();
        $logDataFac = new LoginLogData();

        //增加了使用unionid 先查询有没有用户
        if ($this->request->has('data.unionid')) {
               $unionid = $this->request->input('data.unionid');
            
               $user = $data->getUserWhereUnion($unionid);
            // info(json_encode($user));
            // info('appid1 '.$appid);
            // info('openid1 '.$openid);
            if ($user != null) {
                $userInfo = $adapter->getDataContract($user);
                if ($userInfo['appid'] != $appid || $userInfo['openid'] != $openid) {
                    //查询
                    $info = $data->getUser($unionid, $appid, $openid);
                    // info('info:'.json_encode($info));
                    if (empty($info)) {
                        $userid = array_get($userInfo, 'kkuserid');
                        $model = $data->newitem();
                        $dataInfo = $adapter->getData($this->request);
                        $adapter->saveToModel(false, $dataInfo, $model);
                        $data->add($model, $appid, $openid, $userid);
                    }
                    
                    $appid = $userInfo['appid'];
                    $openid = $userInfo['openid'];
                }
                if ($data->isBind($appid, $openid)) {
                       $res = $data->login($appid, $openid);
                    if (count($res) > 0) {
                        $res = $userAdapter->getDataContract($res);
                        
                        $userLogic = new UserLogic;
                        $res = $userLogic->getUser($res);
                    }

                    //更新微信信息
                    $dataInfo = $adapter->getData($this->request);
                    $adapter->saveToModel(false, $dataInfo, $user);
                    $data->save($user);
                    $logDataFac->addLog();
                    return $this->Success($res);
                } else {
                    $logDataFac->addLog();
                    return $this->Success();
                }
            }
        }

        $userInfo = $data->getInfo($appid, $openid);
        // info(json_encode($userInfo));
        // info('appid2 '.$appid);
        // info('openid2 '.$openid);
        if ($userInfo == null) {
            //插入用户信息 返回未绑定
            $model = $data->newitem();
            $dataInfo = $adapter->getData($this->request);
            $adapter->saveToModel(false, $dataInfo, $model);
            $userid = 0;
            $data->add($model, $appid, $openid, $userid);
            $logDataFac->addLog();
            return $this->Success();
        } else {
            //存在用户信息 查询是否绑定用户
            if ($data->isBind($appid, $openid)) {
                //更新用户的unionid
                if ($this->request->has('data.unionid')) {
                             $unionid = $this->request->input('data.unionid');
                             $data->saveUserUnion($appid, $openid, $unionid);
                }
                //已绑定 返回用户信息 并登陆
                $res = $data->login($appid, $openid);
                if (count($res) > 0) {
                    $res = $userAdapter->getDataContract($res);
                    
                    $userLogic = new UserLogic;
                    $res = $userLogic->getUser($res);
                }

                //更新微信信息
                $dataInfo = $adapter->getData($this->request);
                $adapter->saveToModel(false, $dataInfo, $userInfo);
                $data->save($userInfo);
                $logDataFac->addLog();
                return $this->Success($res);
            } else {
                $logDataFac->addLog();
                //未绑定
                return $this->Success();
            }
        }
    }
}
