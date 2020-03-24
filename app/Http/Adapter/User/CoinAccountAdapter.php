<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class CoinAccountAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id"
        ,"userid"=>"usercoin_account_userid"
        ,"type"=>"usercoin_cointype"
        ,"address"=>"usercoin_address"
        ,"cash"=>"usercoin_cash"
        ,"pending"=>"usercoin_pending"
        ,"price"=>"usercoin_price"
        ,"value"=>"usercoin_value"
        ,"netprice"=>"usercoin_netprice"
        ,"netvalue"=>"usercoin_netvalue"
        ,"change_time"=>"usercoin_change_time"
        ,"settelment_time"=>"usercoin_settelment_time"
        ,"primarycash"=>"usercoint_primarycash"
        ,"isprimary"=>"usercoint_isprimary"
        ,'date'=>"created_at"
    );
}
