<?php
namespace App\Http\Adapter\Pay;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class PayMethodsAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"method_name"
    ,"inputrequireclass"=>"method_inputrequireclass"
    ,"inputclass"=>"method_inputclass"
    ,"invokeclass"=>"method_invokeclass"
    ];

    protected $dicArray = [

    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
