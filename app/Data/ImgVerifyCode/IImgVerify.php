<?php
namespace App\Data\ImgVerifyCode;

/**
 * 图形验证码的接口
 *
 * @author  zhoutao
 * @date    2017.8.31
 * @version 1.0
 **/
interface IImgVerify
{


    /** 
     * 获取图形验证码
     *
     * @return  base64 的图片
     * @author  zhoutao
     * @date    2017.8.31
     * @version 1.0
     **/
     
    public function getLoginCode();

    /** 
     * 判断图形验证码是否正确
     *
     * @param   $userCode 用户输入的验证码
     * @return  正确 true 不一样 false
     * @author  zhoutao
     * @date    2017.8.31
     * @version 1.0
     **/
    public function checkLoginCode($userCode);
}