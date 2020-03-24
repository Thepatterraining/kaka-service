<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;

class AddressData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\Address::class;



    public function CreateAddress($address)
    {
        $item = $this->GetFirst([
        "address"=>$address
        ]);
        if ($item == null) {
            $item = $this->NewItem();
            $item ->address = $address;
            $item -> block =0;
            $item -> save();
        }
        return $item ;
    }

    public function UpdateBlock($address, $blk)
    {
        $item = $this->GetFirst([
            "address"=>$address
            ]);

        if ($item!=null && $item->block < $blk) {
            $item->block = $blk;
            $item->save();
        }
    }
}
