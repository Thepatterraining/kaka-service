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
class PayUserAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"pay_no"
    ,"sysBankNo"=>"pay_sysbankno"
    ,"userid"=>"pay_userid"
    ,"amount"=>"pay_amount"
    ,"type"=>"pay_type"
    ,"status"=>"pay_status"
    ,"jobType"=>"pay_jobtype"
    ,"jobNo"=>"pay_jobno"
    ,"note"=>"pay_note"
    ,"payuser"=>"pay_payuser"
    ,"paytime"=>"pay_paytime"
    ,"ischeck"=>"pay_ischeck"
    ,"checkuser"=>"pay_checkuser"
    ,"checktime"=>"pay_checktime"
    ];

    protected $dicArray = [
        "status"=>"payuser_status",
        "type"=>"payuser_type",
        "jobType"=>"payuser_jobtype",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
