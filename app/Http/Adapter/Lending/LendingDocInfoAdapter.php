<?php
namespace App\Http\Adapter\Lending;

use App\Http\Adapter\IAdapter;

/**
 * 拆解的adapter
 *
 * @author zhoutao
 * @date   2017.11.9
 */
class LendingDocInfoAdapter extends IAdapter
{
    protected $mapArray = [
         "no"=>"lending_docno"
        ,"coinType"=>"lending_coin_type"
        ,"amount"=>"lending_coin_ammount"
        ,"coinScale"=>"lending_coin_scale"
        ,"coinPrice"=>"lending_coin_price"
        ,"deposit"=>"lending_deposit"
        ,"lendTime"=>"lending_lendtime"
        ,"lendUser"=>"lending_lenduser"
        ,"lever"=>"lending_scale"
        ,"checkUser"=>"lending_checkuser"
        ,"checkTime"=>"lending_checktime"
        ,"type"=>"lending_type"
        ,"status"=>"lending_status"
        ,"planReturnTIme"=>"lending_plan_returntime"
        ,"returnTime"=>"lending_return_time"
        ,"returnCheckTime"=>"lending_return_checktime"
        ,"returnCheckUser"=>"lending_return_checkuser"
        ,"sysAccount"=>"lending_sys_account"
        ,"createdTime"=>"created_at"
        ,"projectName"=>"project_name"
    ];

    protected $dicArray = [
        "type"=>"lending_docinfo_type",
        "status"=>"lending_docinfo_status"
    ];

    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
