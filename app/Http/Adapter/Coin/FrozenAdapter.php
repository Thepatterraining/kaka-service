<?php
namespace App\Http\Adapter\Coin;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class FrozenAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"frozen_no"
        ,"cointype"=>"frozen_cointtype"
        ,"coinaccoint"=>"frozen_coinaccoint"
        ,"userid"=>"frozen_userid"
        ,"type"=>"frozen_type"
        ,"jobno"=>"frozen_jobno"
        ,"deadline"=>"frozen_deadline"
        ,"status"=>"frozen_status"
    ];

    protected $dicArray = [
        "type"=>"coin_frozen",
        "status"=>"frozen_status"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
