<?php
namespace App\Http\Adapter\User;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class CashFreezonDocAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"usercash_freezondoc_no"
    ,"notes"=>"usercash_freezondoc_notes"
    ,"userid"=>"usercash_freezondoc_userid"
    ,"accountid"=>"usercash_freezondoc_accountid"
    ,"amount"=>"usercash_freezondoc_amount"
    ,"checkUser"=>"usercash_freezondoc_checkuser"
    ,"checkTime"=>"usercash_freezondoc_checktime"
    ,"success"=>"usercash_freezondoc_success"
    ,"type"=>"usercash_freezondoc_type"
    ,"status"=>"usercash_freezondoc_status"
    ];

    protected $dicArray = [
        "status"=>"usercash_freezondoc_status",
        "type"=>"usercash_freezondoc_type",
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
