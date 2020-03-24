<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class UserAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id",
        "loginid"=>"user_id",
        "nickname"=>"user_nickname",
        "name"=>"user_name",
        "idno"=>"user_idno",
        "mobile"=>"user_mobile",
        "status"=>"user_status",
        "lastlogin"=>"user_lastlogin",
        "with"=>"user_with",
        "withdate"=>"user_with_date",
        "headimgurl"=>"user_headimgurl",
        "dream1"=>"user_dream1",
        "dream2"=>"user_dream2",
        "checkidno"=>"user_checkidno",
        "invcode"=>"user_invcode",
        "currenttype"=>"user_currenttype",
        "nexttype"=>"user_nexttype",
        "currentrbtype"=>"user_currentrbtype",
        "nextrbtype"=>"user_nextrbtype",
        "mobileProvince"=>"mobile_province",
        "mobileCity"=>"mobile_city",
        "mobileCompany"=>"mobile_company",
        "mobileCardtype"=>"mobile_cardtype",
        "idProvince"=>"id_province",
        "idCity"=>"id_city",
        "idTown"=>"id_town",
        "idArea"=>"id_area",
        "sex"=>"user_sex",
        "idBirth"=>"id_birth",
        
    );

    protected $dicArray = [
        "status"=>"user_status",
    ];

    protected $fmtArray = [
        "idno"=>'substr_replace($item,substr(\'**********\',0,strlen($item) - 8),4,-4)',
    ];
}
