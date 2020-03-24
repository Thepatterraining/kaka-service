<?php
namespace Cybereits\Modules\KYC\Controller;

use Cybereits\Http\IController ;
use Cybereits\Modules\KYC\APIFactory;

class Status extends IController
{
    public function run()
    {
        $env = config("app.env");
        $fac = new APIFactory();
        $this->Success(
      [
        "env"=>$env,
        "mail"=>get_class($fac->CreateCheckIDLogic()),
        "idcheck"=>get_class($fac->CreateSendMailLogic()),
        "queryinfo"=>get_class($fac->CreateQueryInfoLogic()),
      
      ]
      );
    }
}
