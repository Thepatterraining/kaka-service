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
class QuartersAdapter extends IAdapter
{
    protected $mapArray = [
         "cointype"=>"coin_type"
        ,"itemid"=>"item_id"
        ,"layout"=>"layout"
        ,"space"=>"space"
        ,"date"=>"date"
        ,"total"=>"total"
        ,"price"=>"price"
        ,"age"=>"age"
        ,"rowards"=>"rowards"
        ,"number"=>"number"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
