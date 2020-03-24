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
class AuthGroupAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"groupName"=>"authgroup_name"
    ,"groupNote"=>"authgroup_note"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
