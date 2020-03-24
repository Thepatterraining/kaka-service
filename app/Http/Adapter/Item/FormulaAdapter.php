<?php
namespace App\Http\Adapter\Item;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class FormulaAdapter extends IAdapter
{
    protected $mapArray = [
         "cointype"=>"coin_type"
        ,"itemid"=>"item_id"
        ,"image"=>"iamge"
        ,"file"=>"file"
        ,"filename"=>"file_name"
        ,"type"=>"type"
    ];

    protected $dicArray = [
        "type"=>"item_formula_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
