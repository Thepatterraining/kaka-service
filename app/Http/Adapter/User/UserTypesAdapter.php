<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserTypeAdapter extends IAdapter
{
    protected $mapArray = array(
        "userid"=>"user_id",
        "usertypeid"=>"usertype_id",
    );

    protected $dicArray = [
       
    ];
}
