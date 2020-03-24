<?php
namespace App\Data\Sys;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class LockData
{






    private $guid;
    public function __construct()
    {
        $this->guid = uniqid("", true);
    }

    /**
     *
     * @param  key 值
     * @
     */
    public function lock($name, $timeout = 10, $expire = 15, $waitIntervalUs = 100000)
    {
        $guid = $this->guid;
 
        if (empty($name)) {
            return false;
        }
        
        $timeout = (int)$timeout;
        $expire = max((int)$expire, 5);
        $now = microtime(true);
        $timeoutAt = $now + $timeout; //过期的时间
        $expireAt = $now + $expire; //超
        
        $redisKey = "Lock:$name";
        while (true) {
            $result =Redis::setnx(
                $redisKey, (string)$expireAt
            );


            //如果从这里挂掉了 Step1
            if ($result == 1) {
                Redis::command('expire', [$redisKey, $expire]); //过期时间
                $this->lockedNames[$name] = $expireAt;
                //  Log::info("$guid Success");
                return true;
            }

            
            
            //以秒为单位，返回$redisKey 的剩余生存时间
            $ttl = Redis::command('ttl', [$redisKey]);
            //Log::info("$guid  ttl $ttl");
            // TTL 小于 0 表示 key 上没有设置生存时间(key 不会不存在, 因为前面 setnx 会自动创建)
            // 如果出现这种情况, 那就是进程在某个实例 setnx 成功后 crash 导致紧跟着的 expire 没有被调用. 这时可以直接设置 expire 并把锁纳为己用
            if ($ttl === -1) {
                //Step1 的情况 有Key 没有设置超时
                //continue;
                $lstTimeOut = Redis::get($redisKey);
                if ($lstTimeOut<$now) { //存储的过期时间 本次的过期时间
                    //上一个挂掉了
                    Log::Info("上一个挂了 $lstTimeOut $expireAt");
                      $result = Redis::setex(
                          $redisKey, $expire, (string)$expireAt
                      );
                    $this->lockedNames[$name] = $expireAt;
                            return true;
                }
                // Log::Info("没执行完,再等等");
              
    
                continue;
            }
            
            // 设置了不等待或者已超时
            if ($timeout <= 0 || microtime(true) > $timeoutAt) {
                break;
            }
 
            usleep($waitIntervalUs);
        }
        //
        // Log::info(" $guid  lock $name Fails");
        return false;
    }
    public function unlock($key)
    {
        $guid = $this->guid;
           // Log::info("$guid Unlock $key");
        $name = $key;
        if ($this->isLocking($name)) {
            if (Redis::command('del', ["Lock:$name"])) {
                // Log::info("$guid Unlock $key");
                unset($this->lockedNames[$name]);
                 return true;
            }
        }
        return false;
    }

    public function isLocking($name)
    {
        if (isset($this->lockedNames[$name])) {
            return (string)$this->lockedNames[$name] == (string)Redis::get("Lock:$name");
        }
         return false;
    }
}
