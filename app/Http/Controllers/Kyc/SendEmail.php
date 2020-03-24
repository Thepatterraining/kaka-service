<?php

namespace App\Http\Controllers\Kyc;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\KYCCheck;

/**
 * 地址认证查询
 * 
 * @author liu <liusimeng@kakamf.com>
 * @date   2017.12.11
 */
class SendEmail extends Controller
{
    const KEY="timeout";
    protected $validateArray=[
        "email"=>"required",
    ];

    protected $validateMsg = [
        "email.required"=>"请输入邮箱地址",
    ];


    /**
     * @api {post} email/sendcode 发送验证邮件
     * @apiName SendEmail
     * @apiGroup kyc
     * @apiVersion 0.0.1
     *
     * @apiParam {string} email 邮箱地址
     *
     * @apiParamExample {json} Request-Example:
     *  {
     *      email : "asc@111.com",
     *  }
     *
     * @apiSuccess {number} code 状态码 = 0 成功
     * @apiSuccess {string} msg 调用成功
     * @apiSuccess {datetime} datetime 调用时间
     * @apiSuccess {object} data 返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     * {
     *      code : 0,
     *      msg  : '调用成功',
     *      datetime : '2017-05-17 14:15:59',
     *      data : {
     *          "status"      : {
     *              "no"   : "CAS00",
     *              "name" : "已提交",
     *          }
     *      }
     * }
     */
    public function run()
    {
        $tokenData = new AccessToken;
        $data = new SendSmsData();
        $email = $this->request->input('email');
        $userData = new UserData();
        //如果取到手机号，说明操作频繁，返回错误
        $redisEmail = Redis::command('get', [self::KEY . $email]);
        if (!empty($redisEmail)  && $redisEmail == $email) {
            return $this->Error(ErrorData::OPER_FREQUENT);
        }
        $user = $userData->getUser($email);
        if ($user != null) {
            return $this->Error(ErrorData::$USER_REQUIRED);
        }
        $verify=rand(100000,999999);
        Mail::to([$email])->send(new KYCCheck($verify));

        $timeout = 300;
        $tokenData->setVerfiy($email, $verify, $timeout);
        //增加时间限制
        $timeout = 60;
        $tokenData->setVerfiy(self::KEY . $email, $email, $timeout);
        
        $res = '邮件验证码发送成功！';
        return $this->Success($res);
    }
}
