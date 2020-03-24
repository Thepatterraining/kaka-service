<?php
namespace Cybereits\Modules\KYC\API;
//        Cybereits\Modules\KYC\Cybereits\Modules\KYC\API\CheckIDLomo
use Cybereits\Modules\KYC\API\ICheckID ;
use Cybereits\Modules\KYC\API\AliQueryInfo;

class CheckIDAli implements ICheckID {

  public function  CheckID ($idno,$name){


    $result = AliQueryInfo::QueryID($idno,$name);
    
  
    return $result->resp->code== 0? true :false ;
  }
}