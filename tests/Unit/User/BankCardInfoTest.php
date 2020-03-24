<?php

namespace Tests\Unit\User;
use Tests\TestCase;
use App\Data\Cash\FinanceBankData;
 

class BankCardInfoTest extends TestCase
{
  
  public function  testAddUserBankCard (){

    $name = "葛云飞";
    $no = "6225881010728375";
    $mobile = "13521510781";

    $bkData  = new FinanceBankData();
    $bkData -> addBankCard( $no, $name, "默认支行", $mobile);

  }
}