<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class CashAccountAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id"
        ,"userid"=>"account_userid"
        ,"cash"=>"account_cash"
        ,"pending"=>"account_pending"
        ,"change_time"=>"account_change_time"
        ,"settelment_time"=>"account_settelment_time"
    );
}
