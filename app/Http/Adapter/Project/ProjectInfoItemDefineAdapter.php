<?php
namespace App\Http\Adapter\Project;

use App\Http\Adapter\IAdapter;

class ProjectInfoItemDefineAdapter extends IAdapter
{
    protected $mapArray = [
         "name"=>"item_name"
        ,"dataType"=>"item_datatype"
        ,"preNote"=>"item_prenote"
        ,"lastNote"=>"item_lastnote"
        ,"dataFmt"=>"item_datafmt"
        ,"displayFmt"=>"item_displayfmt"
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
