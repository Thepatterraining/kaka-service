<?php
namespace Cybereits\Modules\KYC\API;
use Cybereits\Modules\KYC\API\ICheckID ;
class CheckIDTest implements ICheckID {

  public function  CheckID ($idno,$name){
	info('check id '.$idno.' '.$name);
	return true;
  }
}
