<?php
namespace Cybereits\Modules\KYC\Handler;

use Cybereits\Common\Event\IHandleLogic;
use Cybereits\Modules\KYC\Mail\CheckCodeMail;
use Illuminate\Support\Facades\Mail;
use Cybereits\Modules\KYC\APIFactory;

class SendMail implements IHandleLogic
{
    public function Handle($data)
    {
        $mail = $data["email"];
        $code = $data["checkcode"];
        $fac = new APIFactory();
        $sendCloud = $fac->CreateSendMailLogic();
        $sendCloud->SendCheckCodeEmail($mail, $code);
    }
}
