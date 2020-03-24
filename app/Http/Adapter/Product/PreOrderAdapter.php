<?php
namespace App\Http\Adapter\Product;

use App\Http\Adapter\IAdapter;

class PreOrderAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"preorder_no"
        ,"productNo"=>"preorder_product"
        ,"count"=>"preorder_count"
        ,"voucherNo"=>"preorder_voucherinfo"
        ,"userid"=>"preorder_userid"
    ,"status"=>"preorder_status"
    ,"rechargeNo"=>"preorder_rechargeno"
    ,"buyNo"=>"preorder_buyno"
    ];

    protected $dicArray = [
    "status"=>"preorder_status",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
