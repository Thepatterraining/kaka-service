<?php
namespace App\Data\Sys;

use App\Data\Sys\LockData;

class JobsLock
{


    private $lock;
    public function __construct()
    {
        $this->lock = new LockData();
    }


    public function lockSysCoin($coinType)
    {
    }
    public function unlockSysCoin($coinType)
    {
    }
    public function lockUserCoin($coinType, $userid)
    {
        $lockKey = "COIN${coinType}USER${userid}";
        return $this->lock->lock($lockKey);
    }
    public function unlockUserCoin($coinType, $userid)
    {
        $lockKey = "COIN${coinType}USER${userid}";
        return $this->lock->unlock($lockKey);
    }
}
