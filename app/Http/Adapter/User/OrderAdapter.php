<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

class OrderAdapter extends IAdapter
{
    protected $mapArray = array(
        "id"=>"id"
        ,"no"=>"userorder_no"
        ,"type"=>"userorder_type"
        ,"jobno"=>"userorder_jobno"
        ,"orderno"=>"userorder_orderno"
        ,"userorder_cointype"=>"userorder_cointype"
        ,"price"=>"userorder_price"
        ,"coin"=>"userorder_coin"
        ,"discounttype"=>"userorder_discounttype"
        ,"discountno"=>"userorder_discountno"
        ,"fee"=>"userorder_fee"
        ,"ammount"=>"userorder_ammount"
        ,"userid"=>"userorder_userid"
    );

    protected $dicArray = [
        "type"=>"userorder",
    ];
}
