<?php
namespace App\Data\API\LomoCoin;

use App\Data\API\LomoCoin\IVerify;

/** 
 * 实名认证测试类
 *
 * @author  geyunfei@kakamf.com
 * @date    Auth 25th,2017
 * @version 1.0
 **/

class TestVerify implements IVerify
{
    public function VerifyId($name,$id)
    {
        return true;
    }
}