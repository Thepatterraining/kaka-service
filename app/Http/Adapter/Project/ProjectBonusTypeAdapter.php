<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectBonusTypeAdapter extends IAdapter
{
    protected $mapArray = [
         "bonusName"=>"bonus_name"
        ,"bonusType"=>"bonus_type"
        ,"bonusCyc"=>"bonus_cyc"
        ,"bonusConfirmInfo"=>"bonus_confirminfo"
        ,"bonusConfirmExp"=>"bonus_confirmexp"
        ,"bonusDiviendInfo"=>"bonus_diviendinfo"
        ,"bonusDiviendExp"=>"bonus_diviendexp"
        ,"bonusRate"=>"bonus_rate"
    ];

    protected $dicArray = [
        
    ];
    protected function fromModel($contract, $model, $items)
    {
    }
    protected function toModel($contract, $model, $items)
    {
    }
}
