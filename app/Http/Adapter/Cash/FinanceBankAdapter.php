<?php
namespace App\Http\Adapter\Cash;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class FinanceBankAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"bank_no"
        ,"name"=>"bank_name"
        ,"short"=>"bank_short"
        ,"fullname"=>"bank_fullname"
        ,"source"=>"bank_source"
        ,"icon"=>"bank_icon"
        ,"ischeck"=>"bank_ischeck"
        ,"checkser"=>"bank_checkser"
    ];

    protected $dicArray = [
        "source"=>"bank_source",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
