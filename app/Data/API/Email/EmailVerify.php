<?php
namespace App\Data\API\Email;
use App\Data\API\Email\IEmailVerify;
use App\Data\Sys\SendEmailData;
use iscms\AlismsSdk\TopClient;
use iscms\Alisms\SendsmsPusher;
use Illuminate\Support\Facades\Redis;

Class EmailVerify implements IEmailVerify
{

    public function RequireEmail($res,$type)
    {
        return true;
    }

    /**
     * 判断验证码是否正确
     * @param $email 邮箱
     * @param $code 验证码
     * @author zhoutao
     * @date 2017.11.20
     */
    public function CheckEmail($email,$code)
    {
        if (Redis::exists($email) && Redis::get($email) == $code) {
            //清空验证码
            Redis::command('del', [$email]);
            return true;
        }
        return false;
    }
}