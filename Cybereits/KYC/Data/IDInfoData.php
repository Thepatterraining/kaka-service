<?php 
namespace Cybereits\Modules\KYC\Data;

use  Cybereits\Modules\KYC\Data\IDInfoZhData;
use Cybereits\Modules\KYC\Data\EmailCheckData;
use Cybereits\Modules\KYC\Data\PhoneData;
use Cybereits\Modules\KYC\Data\EmailData;
use Cybereits\Modules\KYC\Data\EthAddressData;
use Illuminate\Support\Facades\DB;
class IDInfoData
{
    public function RegIDInfo($name, $id, $mobile, $email, $checkcode,$address)
    {

        DB::beginTransaction();
        $idFac = new IDInfoZhData();
        $emailcheck = new EmailCheckData();
        $emaildata = new EmailData();
        $phone = new PhoneData();
        $addressData = new EthAddressData();
        $emailcheck -> CheckEmail($email, $checkcode);
        $idFac -> AddIdInfo($name, $id);
        $emaildata->AddEmail($name, $id, $email);
        $phone->AddPhone($name, $id, $mobile);
        $addressData->AddAddress($name,$id,$address);
        DB::commit();
        
    }
}
