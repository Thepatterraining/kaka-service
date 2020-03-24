<?php
namespace Cybereits\Modules\KYC\Controller;
use Cybereits\Http\IController ;
use Cybereits\Modules\KYC\Data\EmailCheckData; 

class RequireEmail extends IController {
  public function run (){
    $email = $this->request->input("email");
    $mailCheck = new EmailCheckData();
    $mailCheck->RequireEmailCheck($email);
    $this->Success();
  }
}
