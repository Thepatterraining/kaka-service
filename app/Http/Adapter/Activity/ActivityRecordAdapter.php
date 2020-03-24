<?php
namespace App\Http\Adapter\Activity;

use App\Http\Adapter\IAdapter;

/**
 * Code Generate By KaKa Lazy Tools.
 *
 * @todo    Code Review Required And Leave Your NAME under.
 * @author  your name.<youremail@kakamf.com>
 * @version 0.0.1
 **/
class ActivityRecordAdapter extends IAdapter
{
    protected $mapArray = [
    "id"=>"id"
    ,"no"=>"inviitation_no"
    ,"invuser"=>"inviitation_user"
    ,"reguser"=>"inviitation_reguser"
    ,"invtype"=>"inviitation_type",
    "code"=>"inviitation_code"
         
    ];


    protected $dicArray = [
        "invtype"=>"invitation",
    ];
    protected function fromModel($contract,$model,$items)
    {
    }
    protected function toModel($contract,$model,$items)
    {
    }
}
