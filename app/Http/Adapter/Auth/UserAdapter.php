<?php
namespace App\Http\Adapter\Auth;

use App\Http\Adapter\IAdapter;

class UserAdapter extends IAdapter
{
    protected $mapArray = array(
        "loginid"=>"auth_id",
        "nickname"=>"auth_nickname",
        "name"=>"auth_name",
        "idno"=>"auth_idno",
        "mobile"=>"auth_mobile",
        "sex"=>"auth_sex",
        "status"=>"auth_status",
        "lastlogin"=>"auth_lastlogin",
        "email"=>"auth_email"
    );

    protected $dicArray = [
        "status"=>"user_status",
    ];
}
