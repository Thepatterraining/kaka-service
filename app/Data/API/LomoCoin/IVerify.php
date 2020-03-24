<?php
namespace App\Data\API\LomoCoin;
        //App\Data\API\LomoCoin\IVerify'
            //

/**
 * 实名认证的接口
 *
 * @author  geyunfei@kakamf.com
 * @date    Aug 25th,2017
 * @version 1.0
 **/
interface IVerify
{


    /** 
     * 实名验证信息
     *
     * @param   name string 姓名
     * @param   id string 身份证号
     * @return  姓名身份证相符 true /不符 false 
     * @author  geyunfei@kakamf.com
     * @date    Aug 25th,2017
     * @version 1.0
     **/
     
    public function VerifyId($name,$id);
}