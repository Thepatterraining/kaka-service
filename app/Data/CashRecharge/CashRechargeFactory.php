<?php
namespace App\Data\CashRecharge; 

use App\Data\Payment\PayChannelData;
use App\Data\User\UserTypeData;

/**
 * 现金充值工厂
 *
 * @author zhoutao
 * @date   2017.11.21
 */
class CashRechargeFactory
{

    public function createData($channelid = 0, $bankCard = '')
    {

        $session = resolve('App\Http\Utils\Session');

        $cfg_array = config('recharge.cashRecharge');

        $env = config("app.env");

        $data = new TestCashRechargeData;
        
        $key = (string)$channelid ;
        if (is_array($cfg_array) && count($cfg_array)>0 && array_key_exists($key, $cfg_array)) {
            if (array_key_exists($env, $cfg_array[$key])) {
                $ins_class = $cfg_array[$key][$env];
                if (class_exists($ins_class)) {
                    $data = new $ins_class;
                }           
            }
        }
        $data->load_data($channelid, $bankCard);
        return $data;
    }
}
