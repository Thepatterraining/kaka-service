<?php
namespace Cybereits\Modules\KYC\Handler;

use Cybereits\Common\Event\IHandleLogic;
use Cybereits\Modules\KYC\APIFactory;
use Cybereits\Modules\KYC\Data\EmailData;
class SendRegMail implements IHandleLogic
{
    public function Handle($data)
    {
        $name = $data["name"];
        $idno = $data["idno"];
        $address = $data["address"];
        $scale = 11111;//$data["scale"];
        $emailfac = new EmailData();
        $mailInfo = $emailfac->GetFirst(
          ["idno"=>$idno]
        );
        if ($mailInfo !=null) {
            $email = $mailInfo ->email;
            $fac = new APIFactory();
            $sendCloud = $fac->CreateSendMailLogic();
            $sendCloud->SendRegSuccessEmail(
              $email, 
              $name,
              $address,
              $scale
            );
        }
    }
}
