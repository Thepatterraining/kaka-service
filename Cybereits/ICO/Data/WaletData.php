<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Modules\ICO\Data\AddressData;

class WaletData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\Walet::class;



    public function UpdateAmount($address, $amount, $coin="ETH")
    {
        $addFac = new AddressData();
        $add = $addFac -> CreateAddress($address);
        $item = $this->GetFirst(
      [
        "address"=>$address,
        "address_coin_name"=>$coin
      ]
      );

    
        if ($item == null) {
            $item = $this->NewItem();
            $item->address = $address;
            $item->address_coin_name = $coin;
        }
        $item->address_amount = $amount;
        $item->save();
    }

    public function CreateWalet($address, $type, $coin="ETH")
    {
        $addFac = new AddressData();
        $add = $addFac -> CreateAddress($address);
        $item = $this->GetFirst(
      [
        "address"=>$address,
        "address_coin_name"=>$coin
      ]
      );
        if ($item == null) {
            $item = $this->NewItem();
            $item->address = $address;
            $item->address_coin_name = $coin ;
        }
        $item->address_type_name = $type;
        $item->save();
    }

    public function GetTotal()
    {
        $modelclass = $this->modelclass;
        return $modelclass::where('address_coin_name','ETH')->sum("address_amount");
    }
}
