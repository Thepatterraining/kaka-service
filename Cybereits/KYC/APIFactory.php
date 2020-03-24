<?php
namespace Cybereits\Modules\KYC;
//        Cybereits\Moduels\KYC\API
use Cybereits\Common\Utils\ReflectionHelper;

class APIFactory {

  private $_idlogic = [
           //Cybereits\Moduels\KYC\API\CheckIDLomo
    "local"=>  \Cybereits\Modules\KYC\API\CheckIDAli::class,
    "testing"=>\Cybereits\Modules\KYC\API\CheckIDAli::class,
    "alpha"=>\Cybereits\Modules\KYC\API\CheckIDTest::class,
    "production"=>\Cybereits\Modules\KYC\API\CheckIDAli::class,
  ];
  public function CreateCheckIDLogic(){
    return ReflectionHelper::CreateImplementsLogic($this->_idlogic);
  }
  private $_queryLogic = [
    "local"=>\Cybereits\Modules\KYC\API\AliQueryInfo::class,
    "testing"=>\Cybereits\Modules\KYC\API\AliQueryInfo::class,
    "alpha"=>\Cybereits\Modules\KYC\API\AliQueryInfo::class,
    "production"=>\Cybereits\Modules\KYC\API\AliQueryInfo::class,
  ]; 
  public function CreateQueryInfoLogic(){
    return ReflectionHelper::CreateImplementsLogic($this->_queryLogic);
  }
  private $_emaillogic = [
    "local"=>\Cybereits\Modules\KYC\API\TestMail::class,
    "testing"=>\Cybereits\Modules\KYC\API\TestMail::class,
    "alpha"=>\Cybereits\Modules\KYC\API\TestMail::class,
    "production"=>\Cybereits\Modules\KYC\API\SendCloud::class, 
  ];
  public function CreateSendMailLogic(){
    return ReflectionHelper::CreateImplementsLogic($this->_emaillogic);
  }
}
