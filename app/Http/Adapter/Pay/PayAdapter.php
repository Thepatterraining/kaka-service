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
class PayAdapter extends IAdapter
{
    protected $mapArray = [
        "name"=>"pay_name"
    ,"accessid"=>"pay_accessid"
    ,"accesskey"=>"pay_accesskey"
    ,"cusno"=>"pay_cusno"
    ,"remark1"=>"pay_remark1"
    ,"remark2"=>"pay_remark2"
    ,"remark3"=>"pay_remark3"
    ,"assuserid"=>"pay_assuserid"
    ,"chkuserid"=>"pay_chkuserid"
    ,"settelmentuserid"=>"pay_settelmentuserid"
    ,"withdrawalintype"=>"pay_withdrawalintype"
        ,"withdrawalbankno"=>"pay_withdrawalbankno"
    ,"feebankno"=>"pay_feebankno"
    ,"ammount"=>"pay_ammount"
    ,"pending"=>"pay_pending"
    ,"provisions"=>"pay_provisions"
    ,"type"=>"company_type"
    ,"trusteeship"=>"pay_trusteeship"
    ];

    protected $dicArray = [
        "withdrawalintype"=>"3rd_incometype",
        "type"=>"company_type",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
