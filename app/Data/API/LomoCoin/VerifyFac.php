<?php 
namespace App\Data\API\LomoCoin;

use App\Data\API\LomoCoin\ProductVerify;
use App\Data\API\LomoCoin\TestVerify;

/**
 * 验证类工厂
 *
 * @author  geyunfei@kakamf.com
 * @date    Aug 25th,2017
 * @version 1.0
 * @remark 
 * 读取.env 里的配置变量 app_env 
 * 可选的
 * 测试 testing ,alpha - alpha ，生产 production ,开发 development
 **/

class VerifyFac
{
    public function CreateVerify()
    {

        $cfg_array = config('verify');

        $env = config("app.env");

        if(is_array($cfg_array) 
            && count($cfg_array)>0 
            && array_key_exists($env, $cfg_array)
        ) {
            $ins_class = $cfg_array[$env];

            if(class_exists($ins_class)) {
                return new $ins_class();
            }
        }
        return new TestVerify();

    }
}