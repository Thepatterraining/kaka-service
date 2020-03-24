<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class CashOrderAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id"
        ,"no"=>"usercashorder_no"
        ,"type"=>"usercashorder_type"
        ,"jobno"=>"usercashorder_jobno"
        ,"price"=>"usercashorder_price"
        ,"userid"=>"usercashorder_userid"
        ,"balance"=>"usercashorder_balance"
        ,"createdTime" => "created_at"
    );

    protected $dicArray = [
        "type"=>"usercashorder",
    ];
}
