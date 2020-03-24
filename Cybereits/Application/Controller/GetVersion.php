<?php
namespace Cybereits\Application\Controller;

use Cybereits\Http\IController;
use Cybereits\Application\Data\ReleaseFac;

class GetVersion extends IController
{
    protected function run($param)
    {
        $session = resolve('App\Http\Utils\Session');
        $app_id =// "AC4B7E67-B25F-19AA-EE6D-DC77BAFC1090";//
 $session->appid;
        $fac = new ReleaseFac();
        $item = $fac->getLastRelease($app_id);
        if ($item!=null) {
            $this->Success([
            "version"=>$item->application_version,
            "hash"=>$item->application_filehash,//"6d6ebc678666d3346e1c489069e741c34dd1ad15",
            "url"=>$item->application_dowloadurl,//"cybereits.com",
            "release_date"=>$item->application_releasedate,//"Feb 28,2018",
            "release_note"=>$item->application_releasenote,//"作死不用更",
            "force"=>$item->application_compatible ==0
                  ]);
        } else {
            $this->Success([
            "version"=>"1.0",
            "hash"=>"6d6ebc678666d3346e1c489069e741c34dd1ad15",
            "url"=>"cybereits.com",
            "release_date"=>"Feb 28,2018",
            "release_note"=>"作死不用更",
            "force"=>true
              ]);
        }
    }
}
