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
class CompanyAdapter extends IAdapter
{
    protected $mapArray = [
    "no"=>"company_no"
    ,"name"=>"company_name"
    ,"remark"=>"company_remark"
    ,"type"=>"company_type"
    ];

    protected $dicArray = [
        "type"=>"company_type",
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
