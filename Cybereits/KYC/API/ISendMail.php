<?php
namespace Cybereits\Modules\KYC\API;

interface ISendMail
{
    public function SendCheckCodeEmail($email, $code);
    public function SendRegSuccessEmail($email, $name, $address,$scale);
    public function SendAddressEmail($email, $name, $address, $id, $token,$scale,$eth);
    public function SendReport($email, $amount);
    public function SendAcceptEmail($email, $name, $idno, $acc_amount, $address,$scale);
    public function SendReturnEmail($email,$name,$idno,$eth,$scale,$payaddress,$address);
}
