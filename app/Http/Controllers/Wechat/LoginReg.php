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

class LoginReg extends Controller
{
    protected $validateArray=[
        "openid"=>"required",
        "appid"=>"required",
        "data"=>"required|array",
        "user"=>"required|array",
        // "code"=>"required",
        "verify"=>"required",
        "user.mobile"=>"required",
    ];

    protected $validateMsg = [
        "openid.required"=>"请输入openid!",
        "appid.required"=>"请输入appid!",
        "data.required"=>"请输入data!",
        "data.array"=>"data必须是数组!",
        "user.array"=>"user必须是数组!",
        "user.required"=>"请输入user!",
        "code.required"=>"请输入邀请码!",
        "verify.required"=>"请输入短信验证码!",
        "user.mobile.required"=>"请输入手机号!",
    ];

    /**
     * @api {post} wechat/loginreg 微信登陆注册
     * @apiName loginreg
     * @apiGroup Wechat
     * @apiVersion 0.0.1
     *
     * @apiParam {string} openid openid
     * @apiParam {string} appid appid
     * @apiParam {array} data 微信用户参数
     * @apiParam {array} user 用户信息
     * @apiParam {string} code 邀请码
     * @apiParam {string} verify 验证码
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      openid : openid,
     *      appid  : appid,
     *      code : 'KaKamfv5'
     *      verify : 'KaKamfPwd8080'
     *      data   : {
     *          unionid : unionid,...
     *          微信用户信息
     *      }
     *      user : {
     *          mobile : '177******998'
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
     *      data : {
     *          "loginid" => "DEAF8BB2-35D3-A440-1A19-AB9703855E9B"  登陆id
     *           "nickname" => "" 昵称
     *           "name" => "" 姓名
     *           "idno" => "" 身份证号
     *           "mobile" => "177******998" 手机号
     *           "status" => "US01" 状态
     *           "lastlogin" => null 最后登陆时间
     *           "headimgurl" => "/upload/touxiang/tianping.jpg" 头像
     *           "checkidno" => "0" 是否设置身份证号
     *           "paypwdIsEmpty" => 1 是否设置支付密码
     *           "isSetPaypwd" => 1  是否设置支付密码
     *      }
     *  }
     */
    public function run()
    {
        $request = $this->request->all();
        $openid = $request['openid'];
        $appid = $request['appid'];
        $code = '';
        if ($this->request->has('code')) {
            $code = $this->request->input('code');
        }
        $phone = $this->request->input('user.mobile');

        $data = new UserInfoData();
        $adapter = new UserInfoAdapter();
        $userAdapter = new UserAdapter();
        $userData = new UserData();

        //增加了使用unionid 先查询有没有用户
        // if ($this->request->has('data.unionid')) {
        // 	$unionid = $this->request->input('data.unionid');;
        // 	$userInfo = $data->getUser($unionid,$appid,$openid);
        //     info(json_encode($userInfo));
        //     info('appid1 '.$appid);
        //     info('openid1 '.$openid);
        // 	if ($userInfo == null) {
        // 		//插入用户信息 返回未绑定
        //         $model = $data->newitem();
        //         $dataInfo = $adapter->getData($this->request);
        //         $adapter->saveToModel(false,$dataInfo,$model);
        //         $userid = 0;
        //         $data->add($model,$appid,$openid,$userid);
        // 	}
        // } else {
            //查询微信用户
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
        }
        // }
        
        //查询手机号
            $kkUserInfo = $userData->getUser($phone);
        if (empty($kkUserInfo)) {
            //注册
            $regInfo = $userAdapter ->getData($this->request, 'user');
            $regInfo["status"]="US01";
            $usermodel = $userData->newitem();
            $userAdapter->saveToModel(false, $regInfo, $usermodel);
            $wxInfo['appid'] = $appid;
            $wxInfo['openid'] = $openid;
            $activityRes['activityNo'] = '';
            $activityRes['codeRes'] = '';
            $kkUserInfo = $userData->regWechatUserNoPwd($usermodel, $wxInfo, $activityRes, $code);
            if (!is_object($kkUserInfo)) {
                return $this->Error(ErrorData::$USER_REQUIRED);
            }
        }

            //关联微信用户
            $userData->bind($appid, $openid, $phone);

        if (count($kkUserInfo) > 0) {
            $kkUserInfo['user_lastlogin']=date("Y-m-d h:i:s");//登录成功时，原表不存在上次登陆时间，人为添加当前时间即可
            $userField = ['id','loginid','nickname','name','idno','mobile','status','lastlogin','headimgurl','checkidno','invcode','currentrbtype'];
            $kkUserInfo = $userAdapter->getDataContract($kkUserInfo, $userField);
            
            $userLogic = new UserLogic;
            $kkUserInfo = $userLogic->getUser($kkUserInfo);
        }

            $logDataFac = new LoginLogData();
            $logDataFac->addLog();
            
            return $this->Success($kkUserInfo);
    }
}
