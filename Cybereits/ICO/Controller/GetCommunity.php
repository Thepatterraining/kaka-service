<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;

class GetCommunity extends IController {
  public function run(){

    $fac = new CommunityData ;
    $items= $fac ->GetList();
    $apt = new CommunityAapter();

    $result_item = [];

    foreach ( $items as $item ){
      $result_item[] = $apt->getFromModel($item);

    }

    $this->Success($result_item);
  }
}