<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserBankCardAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"account_no",
        "name"=>"account_name",
        "bank"=>"account_bank"
    );
}
