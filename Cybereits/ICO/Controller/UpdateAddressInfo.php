<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;

use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\KYC\Data\IDInfoData;
use Cybereits\Modules\ICO\Data\WaletData;



class UpdateAddressInfo extends IController
{
    public function run()
    {
        $walet = new WaletData();


        $data = $this->request->input("data");
        foreach ($data as $item) {
        }
        

        $data = $this->request->input("data");
        foreach($data as $item ){
          $address =$item["address"];
          $amount =$item["amount"];
//	  info('update address.'.$address);
          $walet -> UpdateAmount($address, $amount);
        }
    
        $this->Success();
    }
}
