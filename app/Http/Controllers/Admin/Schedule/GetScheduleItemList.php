<?php

namespace App\Http\Controllers\Admin\Schedule;;

use App\Data\Schedule\ScheduleItemData;
use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Schedule\ScheduleItemAdapter;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetScheduleItemList extends QueryController
{

    public function getData()
    {
        return new  ScheduleItemData();
    }

    public function getAdapter()
    {
        return new ScheduleItemAdapter();
    }
}
