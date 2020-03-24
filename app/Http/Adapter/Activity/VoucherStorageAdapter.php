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
class VoucherStorageAdapter extends IAdapter
{
    protected $mapArray = [
        "no"=>"vaucherstorage_no"
        ,"voucherno"=>"vaucherstorage_voucherno"
        ,"activity"=>"vaucherstorage_activity"
        ,"userid"=>"voucherstorage_userid"
        ,"storagetime"=>"voucherstorage_storagetime"
        ,"status"=>"voucherstorage_status"
        ,"jobno"=>"voucherstorage_jobno"
        ,"usetime"=>"voucherstorage_usetime"
        ,"outtime"=>"voucherstorage_outtime"
    ];

    protected $dicArray = [
        "status"=>"voucher_status"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
