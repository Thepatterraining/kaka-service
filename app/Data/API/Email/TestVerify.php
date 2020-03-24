<?php
namespace App\Data\API\Email;

use App\Data\API\Email\IEmailVerify;

/** 
* 短信接口测试类
* @author liu
* @date Auth 25th,2017
* @version 1.0
**/

class TestVerify implements IEmailVerify {
    function RequireEmail($mobile,$type)
    {
        return true;
    }
    
    function CheckEmail($mobile,$code){
        return true;
    }
}   