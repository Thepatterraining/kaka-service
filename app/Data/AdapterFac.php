<?php
namespace App\Data;

class AdapterFac
{


    private $map  = [
      "App\Model\Lending\LendingDocInfo"=>"App\Data\Coin\LendingToFrozenAdapter",
      "App\Model\Trade\TranactionOrder"=>"App\Data\Coin\OrderToFrozenAdapter",
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
