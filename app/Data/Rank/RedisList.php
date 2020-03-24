<?php
namespace App\Data\Rank;
use Illuminate\Support\Facades\Redis;
use App\Data\Sys\LockData;


/**
 * Redis 集合操作集类
 *
 * @author  geyunfei@kakamf.com
 * @date    Auth 18th,2017
 * @version 1.0
 * @date    Auth 24th,2017
 * 加入了锁
 */ 

class RedisList
{
    private $key ;
    private $lock_key ;
    private $sys_lock ;

    /** 
     * 增加某个价格的挂单数量
     *
     * @param price 价格
     * @param count 数量
     */
    public function Add($price,$count)
    {
           

        $this->sys_lock->lock($this->lock_key);

            //以price 为 score 

            $s_count = Redis::ZRANGEBYSCORE($this->key, $price, $price);
           
            //查找是否存在
        if($s_count!=null&&is_array($s_count)&&count($s_count)>0) {
            $s_count = $s_count[0] + $count;
            Redis::ZREMRANGEBYSCORE($this->key, $price, $price); 
        }else {
            $s_count = $count;
        }

            Redis::ZINCRBY($this->key, $price, $s_count);
            $this->sys_lock->unlock($this->lock_key);

    }
    /**
     * 减少某个价格的挂单数量
     *
     * @param price 价格
     * @param count 数量
     */
    public function Remove($price,$count)
    {
          
            //以price 为 score 
            $this->sys_lock->lock($this->lock_key);
            $s_count = Redis::ZRANGEBYSCORE($this->key, $price, $price);
        if($s_count!=null&&is_array($s_count)&&count($s_count)>0) {
            $s_count = $s_count[0] - $count;
            Redis::ZREMRANGEBYSCORE($this->key, $price, $price); 
            if($s_count>0) {
                Redis::ZINCRBY($this->key, $price, $s_count);
            }
        }
            $this->sys_lock->unlock($this->lock_key);
    }

    /**
     * 得到挂单列表
     *
     * @param 要返回的数量 
     */

    public function Get($count)
    {
         $result = Redis::command('zrange', [$this->key,0,$count-1,'WITHSCORES']);
         return $result;

    }


    /**
     * 构造函数
     */
    function __construct($keyName)
    {
        
        $this->key = $keyName;
        $this->sys_lock = new LockData();
        $this->lock_key = "rank_lock".$keyName;
    }
}