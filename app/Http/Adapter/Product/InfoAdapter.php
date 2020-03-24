<?php
namespace App\Http\Adapter\Product;

use App\Http\Adapter\IAdapter;

class InfoAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"product_no"
        ,"name"=>"product_name"
        ,"cointype"=>"product_coin"
        ,"starttime"=>"product_starttime"
        ,"status"=>"product_status"
        ,"owner"=>"product_owner"
        ,"feetype"=>"product_feetype"
        ,"feerate"=>"product_feerate"
        ,"voucherenable"=>"product_voucherenable"
        ,"price"=>"product_price"
        ,"count"=>"product_count"
        ,"amount"=>"product_amount"
        ,"sellno"=>"product_sellno"
        ,"frozentime"=>"product_frozentime"
        ,"endTime"=>"product_endtime"
        ,"revokeTime"=>"product_revoketime"
        ,"completionTime"=>"product_completiontime"
        ,"type"=>"product_type"
    ];

    protected $dicArray = [
        "status"=>"product_status",
        "feetype"=>"fee_rate_type",
        "type"=>"product_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
