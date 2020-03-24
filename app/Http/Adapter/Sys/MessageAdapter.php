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
class MessageAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
        ,"no"=>"msg_no"
    ,"readtime"=>"msg_readtime"
    ,"notify"=>"notify_id"
        ,"status"=>"msg_status"
        ,"url"=>"msg_url"
        ,"text"=>"msg_text"
        ,"to"=>"msg_to"
        ,"type"=>"msg_type"
        ,"pushtime"=>"msg_pushtime"
        ,"docno"=>"msg_docno"
        ,"model"=>"msg_model"
    ];

    protected $dicArray = [
        "status"=>"message_status",
        "type"=>"notify_type"
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
