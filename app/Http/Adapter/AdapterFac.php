<?php
namespace App\Http\Adapter;

class AdapterFac
{


    private $map  = [
      "App\Model\Cash\Recharge"=>"App\Http\Adapter\Cash\RechargeAdapter",
      "App\Model\Cash\Withdrawal"=>"App\Http\Adapter\Cash\WithdrawalAdapter",
      "App\Model\Activity\VoucherInfo"=>"App\Http\Adapter\Activity\VoucherInfoAdapter",
      "App\Model\Trade\TranactionOrder"=>"App\Http\Adapter\Trade\TranactionOrderAdapter",
      "App\Model\User\User"=>"App\Http\Adapter\User\UserAdapter",
      "App\Model\User\CashJournal"=>"App\Http\Adapter\User\CashJournalAdapter",
      "App\Model\Bonus\ProjBonusItem"=>"App\Http\Adapter\Bonus\ProjBonusItemAdapter",
    ];


    public function getDataContract($modelData,$array=null,$getid = false)
    {
        $className = get_class($modelData);
        if (array_key_exists($className, $this->map)) {
            $adpClass = $this->map[$className];
            $adp = new $adpClass();
            $item  = $adp -> getDataContract($modelData, $array, $getid);
            return $item;
        }
        return $modelData;
    }


}
