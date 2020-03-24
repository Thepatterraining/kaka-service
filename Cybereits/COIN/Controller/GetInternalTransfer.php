<?php
namespace Cybereits\Modules\COIN\Controller ;

use Cybereits\Http\IController;
use Cybereits\Modules\COIN\Data\InternalTransData;



class GetInternalTransfer extends IController
{
    public function run()
    {
      
      $transData = new InternalTransData();
      $count = $this->request->count;
	  if($count == null || $count == 0 ){
		$count =100;
	  }
      $result = $transData->GetToTrans($count);
      $this->Success($result);
    }
}
