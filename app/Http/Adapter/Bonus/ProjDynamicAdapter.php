<?php
namespace App\Http\Adapter\Bonus;

use App\Http\Adapter\IAdapter;

class ProjDynamicAdapter extends IAdapter
{
    protected $mapArray = array(
        "no"=>"proj_no",
        "dynamicType"=>"proj_dynamictype",
        "newsNo"=>"proj_newsno",
    );

    protected $dicArray = [
        "dynamicType"=>"prodynamic_type",
    ];
}
