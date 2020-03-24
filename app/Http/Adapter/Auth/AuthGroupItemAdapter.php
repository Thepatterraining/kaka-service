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
class AuthGroupItemAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"groupid"=>"group_id"
    ,"userid"=>"authuser_id"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
