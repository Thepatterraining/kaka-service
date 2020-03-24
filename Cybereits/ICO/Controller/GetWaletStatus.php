<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;

use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\KYC\Data\IDInfoData;


class GetWaletStatus extends IController
{
    public function run()
    {
      
      $orderData = new OrderData();
     $count = $this->request->count;
	if($count == null || $count == 0 ){
		$count =100;
	}
       $result = $orderData->GetWaletToDiscoin($count);
      $this->Success($result);
    }
}
