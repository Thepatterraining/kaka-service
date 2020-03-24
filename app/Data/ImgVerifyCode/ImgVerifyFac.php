<?php 
namespace App\Data\ImgVerifyCode;

use App\Data\API\LomoCoin\ProductVerify;
use App\Data\API\LomoCoin\TestVerify;

/**
 * 验证类工厂
 *
 * @author  zhoutao
 * @date    2017.8.31
 * @version 1.0
 * @remark 
 * 读取.env 里的配置变量 app_env 
 * 可选的
 * 测试 testing ,alpha - alpha ，生产 production ,开发 development
 **/

class ImgVerifyFac
{

    /**
     * 创建工厂
     *
     * @author zhoutao
     * @date   2017.8.31
     */ 
    public function CreateImgVerify()
    {

        $cfg_array = config('imgverify');

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
        return new TestImgVerify();

    }
}