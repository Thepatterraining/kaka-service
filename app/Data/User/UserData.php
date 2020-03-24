<?php
namespace App\Data\User;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegVoucherData;
use App\Data\App\UserInfoData;
use App\Data\Sys\ErrorData;
use App\Data\Utils\DocNoMaker;
use App\Model\User\User;
use App\Data\IDataFactory;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\DB;
use App\Data\User\CashAccountData;
use App\Data\Auth\AccessToken;
use Illuminate\Support\Facades\Redis;
use App\Data\Activity\RegisterInvitationData;
use App\Data\Activity\InvitationData;
use App\Data\Sys\ConfigData;
use App\Data\Sys\LockData;
use App\Data\API\LomoCoin\VerifyFac;
use App\Data\ImgVerifyCode\ImgVerifyFac;
use App\Data\API\AliAPI\API;

/**
 * user operation
 *
 * @date    Auth 25th,,2017
 * @author  geyunfei@kakamf.com
 * @version 1.1
 * 更改了实名认证的接口
 * 主要更改  tongDunApi 
 */

class UserData extends IDatafactory
{
    protected $modelclass = 'App\Model\User\User';

    

    public static $REQ_REQUIRECODE = 'REQ_REQUIRECODE';
    public static $REQ_CODE_LENGTH = 'REQ_CODE_LENGTH';

    const USER_DEFALUT_HEADIMG = '/upload/touxiang/tianping.jpg';
    const USER_HEADIMG_1 = '/upload/touxiang/touxiang_03.png';
    const USER_HEADIMG_2 = '/upload/touxiang/touxiang_05.png';
    const USER_HEADIMG_3 = '/upload/touxiang/touxiang_07.png';
    const USER_HEADIMG_4 = '/upload/touxiang/touxiang_09.png';
    const USER_HEADIMG_5 = '/upload/touxiang/touxiang_11.png';
    const USER_HEADIMG_6 = '/upload/touxiang/touxiang_18.png';
    const USER_HEADIMG_7 = '/upload/touxiang/touxiang_19.png';
    const USER_HEADIMG_8 = '/upload/touxiang/touxiang_20.png';
    const USER_HEADIMG_9 = '/upload/touxiang/touxiang_21.png';
    const USER_HEADIMG_10 = '/upload/touxiang/touxiang_22.jpg';

    const USER_ISEXISTS = -1;

    const USER_STATUS_NORMAL = 'US01';
    const USER_STATUS_FROZEN = 'US02';

    public function getUser($identify)
    {
        


            $user = User::where('id', $identify)
            ->orWhere('user_mobile', $identify)
            ->first();
            return $user;
    }

    /**
     * User Register
     *
     * @author  geyunfei(geyunfei@kakamf.com)
     * @version 0.1
     */
    public function regUser($user, $pwd, $paypwd)
    {
    

        $cashFac = new CashAccountData();

        $token = new AccessToken();

        DB::beginTransaction();
        $cash = $cashFac->newitem();
        $cash->account_cash = 0;
        $cash->account_pending=0;
        $user->user_id = $token->create_guid();
        $this->create($user);
        $cash->account_userid = $user->id;

        $user->user_pwd = md5("pwd".$user->id.$pwd);
        $user->user_paypwd = md5("paypwd".$user->id.$paypwd);
        $cashFac -> create($cash);
        $user->save();

        DB::commit();
        return $user->id;
    }

    public function registUser($user, $pwd)
    {
        $phone = $user->user_mobile;
        //检查用户已注册，返回错误
        $userInfo = $this->getUser($phone);
        if (empty($userInfo)) {

            $cashFac = new CashAccountData();

            $token = new AccessToken();

            DB::beginTransaction();
            $cash = $cashFac->newitem();
            $cash->account_cash = 0;
            $cash->account_pending=0;
            $user->user_id = $token->create_guid();
            $this->create($user);
            $cash->account_userid = $user->id;

            //增加验证码
            $docNo = new DocNoMaker();
            $code = $docNo->getRandomString(8);

            $user->user_pwd = md5("pwd".$user->id.$pwd);
            $user->user_invcode = $code;
            $cashFac -> create($cash);
            $user->save();

            DB::commit();
            return $user->id;
        }
        return self::USER_ISEXISTS;
        
    }

    /**
     * 用户注册
     *
     * @param  $user 
     * @param  $pwd 密码
     * @param  $invCode 邀请码
     * @author zhoutao
     * @date   2017.8.17
     */ 
    public function registUserWithActivity($user, $pwd, $invCode)
    {
        DB::beginTransaction();
        $phone = $user->user_mobile;
        //检查用户已注册，返回错误
        $userInfo = $this->getUser($phone);
        if (empty($userInfo)) {
            $cashFac = new CashAccountData();
            $codeData  = new InvitationCodeData();
            $token = new AccessToken();
            $invData = new InvitationData();
            $regInvData = new RegisterInvitationData();    // step1 生成用户信息
            $cashFac = new CashAccountData();
            $userTypeData = new UserTypeData;
            
            
            $user->user_id = $token->create_guid();

            //使用手机号查询信息
            // $mobileInfo = API::QueryMobileInfo($phone);
            // if (!empty($mobileInfo) && is_object($mobileInfo)) {
            //     $user->mobile_province = $mobileInfo->province;
            //     $user->mobile_city = $mobileInfo->city;;
            //     $user->mobile_company = $mobileInfo->company;;
            //     $user->mobile_cardtype = $mobileInfo->cardtype;;
            // }

            $this->create($user);
            if (!empty($pwd)) {
                $user->user_pwd = md5("pwd".$user->id.$pwd);
            }
            
            // 生成默认现金帐户
            $accountItem = $cashFac ->newitem();
            $accountItem->account_cash = 0;
            $accountItem->account_pending=0;
            $accountItem->account_userid = $user->id;
            $cashFac->create($accountItem);
            
            $sysConfigs = $userTypeData->getData($user->id);
            //用户类型 为1
            $user->user_currenttype = $sysConfigs[UserTypeData::USER_CURRENTTYPE];
            $user->user_currentrbtype = $sysConfigs[UserTypeData::USER_CURRENTRBTYPE];
            // step 2 加入邀请信息
            if (empty($invCode)) {
                //使用 默认邀请码
                $invCode = $sysConfigs[UserTypeData::DEFAULT_INVITATION_CODE];
            }
            $regInvData->AddInviteRecord($user->id, $invCode);
            
            // seep 3 生成邀请码
            $user->user_invcode = $codeData->createCode($user->id);
            $user->user_headimgurl = UserData::USER_DEFALUT_HEADIMG;

            $user->save();
            DB::commit();
            return $user->id;
        }
        DB::commit();
        return self::USER_ISEXISTS;

        
    }

    /**
     * 随机选取头像
     */
    private function randHeadImg()
    {
        $imgs = [
            self::USER_HEADIMG_1,
            self::USER_HEADIMG_2,
            self::USER_HEADIMG_3,
            self::USER_HEADIMG_4,
            self::USER_HEADIMG_5,
            self::USER_HEADIMG_6,
            self::USER_HEADIMG_7,
            self::USER_HEADIMG_8,
            self::USER_HEADIMG_9,
            self::USER_HEADIMG_10,
        ];
        $index = rand(0, count($imgs)-1);
        return $imgs[$index];
    }

    public function tongDunApi($name, $idno)
    {

        
        $fac = new VerifyFac();
        $verify = $fac->CreateVerify();

        return $verify->VerifyId($name, $idno);
    }
    public function newitem()
    {
        $item  = parent::newitem();
        $item->user_status = "US01";
        return $item;
    }

    /**
     * Check the password
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 0.1
     */
    public function checkPwd($user, $pwd)
    {
    
        return $user->user_pwd === md5("pwd".$user->id.$pwd);
    }

    public function checkPaypwd($user, $paypwd)
    {
        return $user->user_paypwd === md5("paypwd".$user->id.$paypwd);
    }

    public function checkPwdPay($userid, $paypwd)
    {
        $userinfo = $this->getUser($userid);
        return $userinfo->user_pwd === md5("pwd".$userinfo->id.$paypwd);
    }

    public function checkPay($userid, $pwd)
    {
        $userinfo = $this->getUser($userid);
        return $userinfo->user_paypwd === md5("paypwd".$userinfo->id.$pwd);
    }


    /**
     * 修改登陆密码
     *
     * @author  zhoutao
     * @version 0.2
     * @date    2017.3.25
     * 增加啦修改登陆用户的登陆密码
     *
     * @param   $phone 手机号
     * @param   $pwd 新的登陆密码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePwd($pwd, $phone = null)
    {
        if ($phone == null) {
            $model = $this->get($this->session->userid);
        } else {
            $model = $this->getUser($phone);
        }
        $model->user_pwd = md5("pwd".$model->id.$pwd);
        return $model->save();
    }

    /**
     * 修改用户手机号
     *
     * @param   $phone 手机号
     * @param   $newPhone 新手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePhone($phone, $newPhone)
    {
        $model = $this->getUser($phone);
        $model->user_mobile = $newPhone;
        return $model->save();
    }

    /**
     * 修改用户支付密码
     *
     * @param   phone 手机号
     * @param   paypwd 支付密码
     * @author  zhoutao
     * @version 0.1
     */
    public function savePayPwd($phone, $paypwd)
    {

        $model = $this->getUser($phone);
        $newPayPwd = md5("paypwd".$model->id.$paypwd);
        //两次支付密码不能一样
        if ($newPayPwd === $model->user_paypwd) {
            $res['res'] = false;
            $res['code'] = 801009;
            return $res;
        }

        //支付密码不能和登陆密码一样
        if ($this->checkPwdPay($phone, $paypwd)) {
            $res['res'] = false;
            $res['code'] = 801006;
            return $res;
        }

        $model->user_paypwd = md5("paypwd".$model->id.$paypwd);
        $res['res'] = $model->save();
        $res['code'] = 801007;
        return $res;
    }

    /**
     * 查找用户登录名
     *
     * @param   $phone 手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserId($phone)
    {
        $user = $this->getUser($phone);
        if ($user == null) {
            return false;
        }
        return $user->user_id;
    }

    /**
     * 查找用户id
     *
     * @param   $phone 手机号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getId($phone)
    {
        $user = $this->getUser($phone);
        if ($user == null) {
            return false;
        }
        return $user->id;
    }

    /**
     * 查询提现次数和时间
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.1
     */
    public function getWith()
    {
        $userInfo = $this->get($this->session->userid);
        $res['with'] = $userInfo->user_with;
        $res['date'] = date('Y-m-d', strtotime($userInfo->user_with_date . "+1 day"));
        return $res;
    }

    /**
     * 增加用户提现次数
     * 增加来提现次数的参数
     *
     * @param   $count 次数
     * @author  zhoutao
     * @version 0.2
     * @date    2017.4.1
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.1
     */
    public function saveUserWith($count)
    {
        $userInfo = $this->get($this->session->userid);
        $userInfo->user_with = $count;
        $userInfo->user_with_date = date('Y-m-d H:i:s');
        return $this->save($userInfo);
    }

    /**
     * 根据用户邀请码查询用户
     *
     * @param   $code 用户邀请码
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.10
     */
    public function getCode($code)
    {
        if (empty($code)) {
            return null;
        }

        $model = $this->modelclass;

        $where['user_invcode'] = $code;

        $userInfo = $model::where($where)->first();
        if ($userInfo == null) {
            return null;
        }
        return $userInfo->user_type;
    }

    /**
     * 微信注册
     *
     * @param  $user
     * @param  $pwd
     * @param  $wxInfo
     * @param  $activityRes
     * @param  $code
     * @return array|mixed
     */
    public function regWechatUser($user, $pwd, $wxInfo, $activityRes, $code)
    {
        $lk = new LockData;
        $lk->lock("regist");

         $phone = $user->user_mobile;
        //检查用户已注册，返回错误
        $userInfo = $this->getUser($phone);
        if (!empty($userInfo)) {
            return ErrorData::$USER_REQUIRED;
        }
            
        $infoData = new InfoData();
        $invitationData = new InvitationCodeData();
        $activityNo = $activityRes['activityNo'];
        $codeRes = $activityRes['codeRes'];

        //普通用户注册
        $userid = $this->registUserWithActivity($user, $pwd, $code);

        if ($userid == self::USER_ISEXISTS) {
            return ErrorData::$USER_REQUIRED;
        }

        $tokenFac = new AccessToken();

        $token = $this->session->token;
        $tokenFac->updateAccessToken($token, $userid);
        
        $res = $this->getUser($userid);

        if (!empty($wxInfo)) {
            $appid = $wxInfo['appid'];
            $openid = $wxInfo['openid'];
            //绑定微信
            $userInfoData = new UserInfoData();
            $userInfo = $userInfoData->getInfo($appid, $openid);
            $userInfo->kkuserid = $userid;
            $userInfo->binding_time = date('Y-m-d H:i:s');
            $userInfoData->save($userInfo);

            $res = $userInfoData->login($appid, $openid);
        }
        $this->session->userid = $userid;

        // //开始执行发券
        // if (!empty($activityNo) || !empty($codeRes)) {
        //     $infoData->addUserActivity($activityNo,$userid);
        //     if ($codeRes == 'INVITATION' && !empty($code)) {
        //         //更改数量
        //         $res = $invitationData->saveCount($code);
        //     }
        // }
        $lk->unlock("regist");
        return $res;
    }


    /**
     * 微信注册 去掉登陆密码
     *
     * @param  $user
     * @param  $wxInfo
     * @param  $activityRes
     * @param  $code
     * @return array|mixed
     */
    public function regWechatUserNoPwd($user, $wxInfo, $activityRes, $code)
    {
        $lk = new LockData;
        $lk->lock("registnopwd");
        $phone = $user->user_mobile;
        //检查用户已注册，返回错误
        $userInfo = $this->getUser($phone);
        if (!empty($userInfo)) {
            return ErrorData::$USER_REQUIRED;
        }

        $infoData = new InfoData();
        $invitationData = new InvitationCodeData();
        $activityNo = $activityRes['activityNo'];
        $codeRes = $activityRes['codeRes'];

        //普通用户注册
        $userid = $this->registUserWithActivity($user, '', $code);

        if ($userid == self::USER_ISEXISTS) {
            return ErrorData::$USER_REQUIRED;
        }
        
        $tokenFac = new AccessToken();

        $token = $this->session->token;
        $tokenFac->updateAccessToken($token, $userid);
        
        $res = $this->getUser($userid);

        if (!empty($wxInfo)) {
            $appid = $wxInfo['appid'];
            $openid = $wxInfo['openid'];
            //绑定微信
            $userInfoData = new UserInfoData();
            $userInfo = $userInfoData->getInfo($appid, $openid);
            $userInfo->kkuserid = $userid;
            $userInfo->binding_time = date('Y-m-d H:i:s');
            $userInfoData->save($userInfo);

            $res = $userInfoData->login($appid, $openid);
        }
        $this->session->userid = $userid;

        // //开始执行发券
        // if (!empty($activityNo) || !empty($codeRes)) {
        //     $infoData->addUserActivity($activityNo,$userid);
        //     if ($codeRes == 'INVITATION' && !empty($code)) {
        //         //更改数量
        //         $res = $invitationData->saveCount($code);
        //     }
        // }
        $lk->unlock("registnopwd");
        return $res;
    }

    /**
     * 支付密码是否为空
     *
     * @author zhoutao
     */
    public function paypwdIsEmpty()
    {
        $userid = $this->session->userid;
        $userInfo = $this->getUser($userid);
        if ($userInfo == null) {
            return ErrorData::$USER_NOT_FOUND;
        }
        if (empty($userInfo->user_paypwd)) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * 获取图形验证码
     *
     * @author zhoutao
     * 
     * 改成了走工厂，判断环境
     * @author zhoutao
     * @date   2017.8.31
     */
    public function getLoginCode()
    {
        $fac = new ImgVerifyFac;
        $imgverify = $fac->CreateImgVerify();

        return $imgverify->getLoginCode();
    }

    /**
     * 判断图形验证码
     *
     * @param  $userCode 用户输入的验证码
     * 
     * 改成了走工厂，判断环境
     * @author zhoutao
     * @date   2017.8.31
     */
    public function checkLoginCode($userCode)
    {
        $fac = new ImgVerifyFac;
        $imgverify = $fac->CreateImgVerify();

        return $imgverify->checkLoginCode($userCode);
    }

    /**
     * 查询邀请码的长度和是否使用邀请码
     *
     * @author zhoutao
     */
    public function getSysCoinfigReq()
    {
        $sysConfigData = new ConfigData();
        $configs = $sysConfigData->getConfigs();

        $sysConfigKey = [
            $this::$REQ_REQUIRECODE => '',
            $this::$REQ_CODE_LENGTH => '',
        ];
        foreach ($configs as $col => $val) {
            if (array_key_exists($val->config_key, $sysConfigKey)) {
                $sysConfigKey[$val->config_key] = $val->config_value;
            }
        }

        $req_requirecode = $sysConfigKey[$this::$REQ_REQUIRECODE];
        $req_code_length = $sysConfigKey[$this::$REQ_CODE_LENGTH];

        $res['need_invitation_code'] = boolval($req_requirecode);
        $res['invitation_code_length'] = $req_code_length;

        return $res;
    }

    /**
     * 判断用户的身份证号码是否为空
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function idnoIsEmpty()
    {
        $userid = $this->session->userid;
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return ErrorData::$USER_NOT_FOUND;
        }

        if ($userInfo->user_checkidno == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 查询用户身份证号
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserIdno($userid)
    {
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return null;
        }
        return $userInfo->user_idno;
    }

    /**
     * 查询用户名称
     */
    public function getUserName($userid)
    {
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return null;
        }
        return $userInfo->user_name;
    }

    /**
     * 根据身份证号返回星座头像
     *
     * @param   $idno 身份证号
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserConstellationHeadImg($idno)
    {
        $month = substr($idno, 10, 2);
        $day = substr($idno, 12, 2);
        $headerArray = [
            '/upload/touxiang/mojie.jpg',
            '/upload/touxiang/shuiping.jpg',
            '/upload/touxiang/shuangyu.jpg',
            '/upload/touxiang/baiyang.jpg',
            '/upload/touxiang/jinniu.jpg',
            '/upload/touxiang/shuangzi.jpg',
            '/upload/touxiang/juxie.jpg',
            '/upload/touxiang/shizi.jpg',
            '/upload/touxiang/chunv.jpg',
            '/upload/touxiang/tianping.jpg',
            '/upload/touxiang/tianxie.jpg',
            '/upload/touxiang/sheshou.jpg',
        ];
        $dayArray = [
            '22',
            '20',
            '19',
            '21',
            '21',
            '21',
            '22',
            '23',
            '23',
            '23',
            '23',
            '22'
        ];
        $index = $month;
        if ($day < $dayArray[$month - 1]) {
            $index -= 1;
        }
        $index %= 12;
        return $headerArray[$index];
    }

    public function getUsers()
    {
        $model = $this->modelclass;
        return $model::all();
    }

    /**
     * 绑定微信
     *
     * @param  $appid
     * @param  $openid
     * @param  $phone 手机号
     * @author zhoutao
     */
    public function bind($appid, $openid, $phone)
    {
            $user = $this->getUser($phone);
        //绑定微信
            $userInfoData = new UserInfoData();
            $userInfo = $userInfoData->getInfo($appid, $openid);
            $userInfo->kkuserid = $user->id;
            $userInfo->binding_time = date('Y-m-d H:i:s');
            $userInfoData->save($userInfo);

            $res = $userInfoData->login($appid, $openid);
    }

    /**
     * 查询用户身份证号
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserInvCode($userid)
    {
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return null;
        }
        return $userInfo->user_invcode;
    }

    /**
     * 查询用户返佣类型
     *
     * @param   $userid 用户id
     * @author  liu
     * @version 0.1
     */
    public function getUserRakeBackType($userid)
    {
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return null;
        }
        return $userInfo->user_currentrbtype;
    }

    public function getAllId()
    {
        $model = $this->modelclass;
        return $model::pluck('user_id');

    }
    public function getMaxId($datetime)
    {
        $model = $this->modelclass;
        $item =  $model::where('created_at', '<=', $datetime)->orderBy('id', 'desc')->first();
        if($item!=null) {
            return $item->id;
        }
        else
        {
            return 0 ; 
        }
    }

    /**
     * 更新用户最新登陆时间
     *
     * @param $userid 用户id
     */
    public function updateLastLoginTime($userid)
    {
        $user = $this->get($userid);
        $user->user_lastlogin = date('Y-m-d H:i:s');
        $this->save($user);
    }

    /**
     *  查询用户注册时间
     *
     * @param  $phone 手机号 
     * @author zhoutao
     * @date   17.8.10
     */
    public function getRegTime($phone)
    {
        $user = $this->getUser($phone);
        if (empty($user)) {
            return null;
        }
        return $user->created_at->format('Y-m-d');
    }

    /**
     * 修改用户状态
     *
     * @param  $userid 用户id
     * @param  $status 状态
     * @author zhoutao
     * @date   2017.8.30
     */ 
    public function saveStatus($userid, $status)
    {
        $user = $this->getUser($userid);
        $user->user_status = $status;
        $this->save($user);
    }

    /**
     * 查询用户状态
     *
     * @param   $userid 用户id
     * @author  zhoutao
     * @version 0.1
     * @date    2017.8.30
     */
    public function getUserStatus($userid)
    {
        $userInfo = $this->getUser($userid);
        if (empty($userInfo)) {
            return null;
        }
        return $userInfo->user_status;
    }

    /**
     * 把2017年9月28日转换成2017-9-28
     *
     * @param  $str 字符串
     * @param  $sign 转换符号
     * @author zhoutao
     * @date   2017.9.28
     */
    public function strToDate($str, $sign = '-')
    {
        if (strstr($str, '年') === false) {
            return $str;
        }
        if (strstr($str, '月') === false) {
            return $str;
        }
        if (strstr($str, '日') === false) {
            return $str;
        }
        $date = str_replace('年', $sign, $str);
        $date = str_replace('月', $sign, $date);
        $date = str_replace('日', '', $date);
        return $date;
    }
}
