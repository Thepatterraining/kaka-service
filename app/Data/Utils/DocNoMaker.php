<?php
namespace App\Data\Utils;

use Illuminate\Support\Facades\Redis;
use App\Data\Sys\LockData;


/**
 * 生成文档编号的类
 *
 * @author  geyunfei@kakamf.com
 * @version 1.0
 * @date    Sep 26th,2017
 */
class DocNoMaker
{
    public static function Generate($PreKey)
    {

        //CCJ 20170315 152728 52883 8+6+5
        return $PreKey.date('YmdHis').substr(rand(100000, 199999), 1);
    }

    /**
     * 5位随机数报表会重复
     * 所以增加随机数位数
     */
    public static function GenerateReport($PreKey)
    {

        //CCJ 20170315 152728 52883 8+6+5
        return $PreKey.date('YmdHis').substr(rand(1000000000, 1999999999), 1);
    }

    public static function getRandomString($len, $chars = null)
    {
        if ($chars == null) {
            $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        }

        $str = '';
        $arr_len = count($chars)-1;
        if ($arr_len > 0 && $len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $str .= $chars[mt_rand(0, $arr_len)];
            }
        }
        return $str;
    }

    


    public static function getContractNo($coinType,$levelType)
    {
        $date = date('Ymd');
        $key = 'KK'.$date.preg_replace('/\D/s', '', $coinType).$levelType;
        $lockData = new LockData();
        $lockData->lock($key);
        
        if (Redis::exists($date.$coinType)) {
            $coinNo = sprintf('%06s', Redis::get($date.$coinType) + 1);
        } else {
            $coinNo = '000001';
        }

        
        $pre = $date - 1;
        Redis::command('del', [$pre.$coinType]);

        Redis::command('set', [$date.$coinType,$coinNo]);
        // Redis::command('expire', [date('Ymd').$coinType,$timeout]);

        $str = $key . $coinNo;
        $lockData->unlock($key);
        return $str;
    }


    public static function getDateSerial($preKey,$pre,$len)
    {
         
        $lockData = new LockData();

        $key = 'serialNo'.$preKey;
        $lockData->lock($key);

        $time = date('Ymd');

        $inrkey = $key.$time;

        $now  =  Redis::command('incr', [$inrkey]);

          
        $lockData->unlock($key);

        return  $pre.$time.sprintf("%010d", $now);//$now;

    }


    public static function getDateSeriaNoPre($preKey ,$len)
    {

           
                $lockData = new LockData();
        
                $key = 'serialNoNoPre'.$preKey;
                $lockData->lock($key);
        
                $time = date('Ymd');
        
                $inrkey = $key.$time;
        
                $now  =  Redis::command('incr', [$inrkey]);
        
                  
                $lockData->unlock($key);
        
                return   $now;
        

    }
    


    public static function getSecondSerial($preKey,$pre,$len)
    {
         
        $lockData = new LockData();

        $key = 'serialNo'.$preKey;
        $lockData->lock($key);

        $time = date('YmdHms');

        $inrkey = $key.$time;

        $now  =  Redis::command('incr', [$inrkey]);
          Redis::command('expire', [$inrkey,10]); //过期时
          
        $lockData->unlock($key);

        return  $pre.$time.sprintf("%010d", $now);//$now;

    }
}
