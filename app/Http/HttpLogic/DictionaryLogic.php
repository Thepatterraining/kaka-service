<?php
namespace App\Http\HttpLogic;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;

class DictionaryLogic
{
    private function getDics($type)
    {
        $dicFac = new DictionaryData();
        $items = $dicFac->getDictionaries($type);
        $adapter = new DictionaryAdapter();
        $result = [];
        foreach ($items as $item) {
            $result[]=$adapter->getDataContract($item, ["no","name"], false);
        }
        return $result;
    }
    
    public function getDic($type, $no)
    {
        $dicFac = new DictionaryData();
        $item = $dicFac->getDictionary($type, $no);
        $adapter = new DictionaryAdapter();
        return $adapter->getDataContract($item, ["no","name"], false);
    }
    public function getBanks()
    {
        return $this->getDics("bank");
    }

    public function getBuyStatus()
    {
        return $this->getDics("trans_buy");
    }

    public function getSellStatus()
    {
        return $this->getDics("trans_sell");
    }


    public function getNewType()
    {
        return $this->getDics("news");
    }
    public function getNewpushType()
    {
        return $this->getDics("newspush");
    }
}
