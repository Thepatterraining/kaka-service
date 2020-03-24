<?php
namespace App\Data\ImgVerifyCode;

use App\Data\ImgVerifyCode\IImgVerify;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Redis;

/** 
 * 图形验证码测试类
 *
 * @author  zhoutao
 * @date    2017.8.31
 * @version 1.0
 **/

class TestImgVerify implements IImgVerify
{

    protected $session;

    const WITHE = 100;
    const HEIGHT = 40;
    const LOGINCODETIME = 1800;

    public function __construct($userid = null)
    {   
        $this->session = resolve('App\Http\Utils\Session');
    }
    
    /** 
     * 获取图形验证码
     *
     * @return  base64 的图片
     * @author  zhoutao
     * @date    2017.8.31
     * @version 1.0
     **/
    public function getLoginCode()
    {
        $builder = new CaptchaBuilder();
        $builder->build(self::WITHE, self::HEIGHT);
        $base64Image = $builder->inline();
        $code = $builder->getPhrase();

        Redis::command('set', ['verificationCode' . $this->session->token,$code]);
        Redis::command('expire', ['verificationCode' . $this->session->token,self::LOGINCODETIME]);

        return $base64Image;
    }

    /** 
     * 判断图形验证码是否正确
     *
     * @param   $userCode 用户输入的验证码
     * @return  正确 true 不一样 false
     * @author  zhoutao
     * @date    2017.8.31
     * @version 1.0
     **/
    public function checkLoginCode($userCode)
    {
        return true;
    }
}
