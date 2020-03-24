<?php

namespace App\Http\Controllers\Wechat;

use App\Data\Activity\InfoData;
use App\Data\Sys\ErrorData;
use App\Data\Sys\SendSmsData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Adapter\User\UserAdapter;
use App\Data\User\UserData;
use Illuminate\Support\Facades\DB;
use App\Data\Auth\AccessToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Data\Activity\ActivityRecordData;
use App\Data\Sys\RakebackTypeData;
use App\Http\Adapter\Sys\RakebackTypeAdapter;
use App\Data\User\BankAccountData;
use App\Http\Adapter\User\UserBankCardAdapter;
use App\Http\Adapter\Sys\BankAdapter;
use App\Data\Sys\BankData;
use App\Http\HttpLogic\BankLogic;
use App\Http\HttpLogic\UserLogic;

class WechatReg extends Controller
{


    protected $validateArray=array(
        // "code"=>"required",
        "pwd"=>"required|min:6|pwd",
        "data.mobile"=>"required|unique:sys_user,user_mobile",
        "appid"=>"required",
        "openid"=>"required",
    );

    protected $validateMsg = [
        "openid.required"=>"请输入openid!",
        "appid.required"=>"请输入appid!",
        "pwd.required"=>"请输入登陆密码!",
        "pwd.min"=>"登陆密码最小6位!",
        "paypwd.required"=>"请输入交易密码!",
        "paypwd.min"=>"交易密码最小6位!",
        "paypwd.alpha_num"=>"交易密码必须是字母或者数字!",
        "data.loginid.required"=>"请输入登陆名!",
        "data.nickname.required"=>"请输入昵称！",
        "data.mobile.required"=>"请输入手机号！",
        "data.mobile.unique"=>"该手机号已注册！",
        "data.name.required"=>"请输入真实姓名!",
        "data.idno.required"=>"请输入合法的身份证号码！",
        "data.idno.unique"=>"该身份证号码已注册！",
        "appid.required"=>"请输入appid!",
        "openid.required"=>"请输入openid!",
    ];

    /**
     *
     * @api {post} wechat/reg 微信注册
     * @apiName UserWechatReg
     * @apiGroup Wechat
     * @apiVersion 0.0.1
     *
     * @apiParam {string} code 邀请码
     * @apiParam {string} pwd 登录密码
     * @apiParam {string} data.mobile 手机号
     * @apiParam {string} appid 微信appid
     * @apiParam {string} openid 微信openid
     *
     * @apiParamExample {json} Request-Example:
     * {
     *      code   : KaKamfv5,
     *      pwd    : 123qwe,
     *      appid  : '1231242qrewarae'
     *      openid : 'werawefklj32423'
     *      data   : {
     *          mobile : 13878654532
     *      }
     *
     * }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *
     * {
     *      code : 0,
     *      msg  : 调用成功,
     *      datetime : ,
     *      data : {
     *          loginid : 登录名,
     *          nickname : 昵称,
     *          name  : 真实姓名,
     *          idno : 身份证号,
     *          mobile : 手机号,
     *          status : 状态,
     *          lastlogin : 最后登陆时间,
     *          headimgurl : 头像,
     *          checkidno : 是否实名,
     *          paypwdIsEmpty : 是否设置支付密码
     *          isSetPaypwd ：是否设置支付密码
     *      }
     * }
     */
    protected function run()
    {

        $adapter = new UserAdapter();
        $datafac = new UserData();
        $infoData = new InfoData();
        $regInfo = $adapter ->getData($this->request);
        $regInfo["status"]="US01";
        $pwd = $this->request->input("pwd");
        $phone = $this->request->input('data.mobile');
        $wxInfo = [];

        //检查用户已注册，返回错误
        $user = $datafac->getUser($phone);
        if (!empty($user)) {
            return $this->Error(ErrorData::$USER_REQUIRED);
        }

        if ($this->request->has('appid') && $this->request->has('openid')) {
            $appid = $this->request->input('appid');
            $openid = $this->request->input('openid');
            $wxInfo['appid'] = $appid;
            $wxInfo['openid'] = $openid;
        }

        $code = '';
        $activityRes['activityNo'] = '';
        $activityRes['codeRes'] = '';
        if ($this->request->has('code')) {
            $code = $this->request->input('code');
        }
        //判断邀请码是否正确
        $recordData = new ActivityRecordData();
        $userCanActivity = $recordData->canInvitation($code, $this->session->userid);
        if ($userCanActivity === false) {
            // return $this->Error(ErrorData::$ACTIVITY_CODE_ERROR);
        }
        if ($userCanActivity !== true) {
            // return $this->Error($userCanActivity);
        }

        //开始注册
        $usermodel = $datafac->newitem();

        $adapter->saveToModel(false, $regInfo, $usermodel);
        $userRes = $datafac->regWechatUser($usermodel, $pwd, $wxInfo, $activityRes, $code);

        if (!is_object($userRes)) {
            return $this->Error(ErrorData::$USER_REQUIRED);
        }

        $adapter = new UserAdapter();
        if (count($userRes) > 0) {
            $userField = ['id','loginid','nickname','name','idno','mobile','status','lastlogin','headimgurl','checkidno','currentrbtype'];
            $userRes = $adapter->getDataContract($userRes, $userField);
            
            $userLogic = new UserLogic;
            $userRes = $userLogic->getUser($userRes);
        }

        //清空验证码
        Redis::command('del', [$phone]);

        $this->Success($userRes);
    }
}
