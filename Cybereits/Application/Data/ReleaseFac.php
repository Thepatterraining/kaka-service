<?php
namespace Cybereits\Application\Data;
use Cybereits\Common\DAL\IMySqlModelFactory;

class ReleaseFac extends IMySqlModelFactory {

  protected $modelclass = \Cybereits\Application\Model\AppRelease::class;

  public function getLastRelease($app_id){

    $filters = [
      "application_guid"=>$app_id
    ];
    $item = $this->_query($filters,["application_version"=>"desc"])->first();
    return $item ;

  }

}
