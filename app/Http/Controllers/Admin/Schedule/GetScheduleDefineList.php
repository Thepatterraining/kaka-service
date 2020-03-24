<?php

namespace App\Http\Controllers\Admin\Schedule;;

use App\Data\Schedule\ScheduleDefineData;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Schedule\ScheduleDefineAdapter;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetScheduleDefineList extends QueryController
{

    public function getData()
    {
        return new  ScheduleDefineData();
    }

    public function getAdapter()
    {
        return new ScheduleDefineAdapter();
    }
}
