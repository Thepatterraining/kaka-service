<?php
namespace App\Http\Adapter\Auth;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ItemAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"auth_no"
    ,"name"=>"auth_name"
    ,"url"=>"auth_url"
    ,"type"=>"auth_type"
    ,"notes"=>"auth_notes"
    ];
    protected $dicArray = [
        'type'=>'auth_type',
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
