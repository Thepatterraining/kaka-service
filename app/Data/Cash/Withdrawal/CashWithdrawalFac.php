<?php 
namespace App\Data\Cash\Withdrawal;

/**
 * 现金提现工厂
 *
 * @author  zhoutao
 * @date    2017.11.27
 * @version 1.0
 * @remark 
 * 读取.env 里的配置变量 app_env 
 * 可选的
 * 测试 testing ,alpha - alpha ，生产 production ,开发 development
 **/
class CashWithdrawalFac
{

    /**
     * 创建工厂
     *
     * @author zhoutao
     * @date   2017.8.31
     */ 
    public function CreateCashWithData()
    {

        $cfg_array = config('withdrawal.cashWithdrawal');

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
        return new TestWithdrawalData;

    }
}