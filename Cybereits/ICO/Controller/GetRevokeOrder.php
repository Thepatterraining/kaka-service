<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;

use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\KYC\Data\IDInfoData;


class GetRevokeOrder  extends IController
{
    public function run()
    {
      $orderData = new OrderData();
      $this->Success($orderData->GetRevokeDocs());
    }
}
