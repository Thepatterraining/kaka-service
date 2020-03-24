<?php
namespace Cybereits\Application\Data;

use Cybereits\Common\DAL\IMySqlModelFactory;
use Cybereits\Application\Data\ReleaseFac;

class AppFac extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Application\Model\Application::class;

    public function createApp($app, $version, $remark)
    {
    }
    public function getLastRelease($app_id)
    {
        $release_fac = new ReleaseFac();
        return $release_fac ->getLastRelease($app_id);
    }

    public function pushRelease($name,$version,$note,$url){

      $filter = ["app_name"=>$name];
      $app = $this->GetFirst($filter);
      if($app == null){
        throw new Exeception("应用不存在");
      }
      $fac = new ReleaseFac;
      $item = $fac -> NewItem();
      $item -> application_id = $app->id;
      $item -> application_guid = $app -> app_id;
      $item -> application_releasenote = $note;
      $item -> application_dowloadurl = $url ;
      $item -> application_compatible = 0;
      $item -> application_version = $version;

      $fac ->Create($item);
    }
}
