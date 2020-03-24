<?php
namespace Cybereits\Modules\ICO\Data;
use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Data\WaletData;

class CompanyOrderData extends IMySqlModelFactory {
  
    protected $modelclass = \Cybereits\Modules\ICO\Model\CompanyOrder::class;

    public function CreateOrder($name,$amount,$address,$payaddress){
      $item = $this->NewItem();
      $item->name = $name;
      $item->amount = $amount;
      $item->address = $address;
      $item->payaddress = $payaddress;
      $type= "机构";
      $waletfac = new WaletData();
      $waletfac->CreateWalet($payaddress, $type);
      $this->Save($item);
      return $item->id;
  }
}