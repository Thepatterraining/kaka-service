<?php
namespace App\Http\Adapter\Sys;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class CoinAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"type"=>"syscoin_account_type"
    ,"address"=>"syscoin_account_address"
        ,"cash"=>"syscoin_account_cash"
        ,"pending"=>"syscoin_account_pending"
        ,"change_time"=>"syscoin_account_change_time"
        ,"settelment_time"=>"syscoint_account_settelment_time"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
