<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\EventLogData;
use App\Http\Adapter\Notify\EventLogAdapter;

class GetEventLogList extends QueryController
{
    public function getData()
    {
        return new EventLogData();
    }

    public function getAdapter()
    {
        return new EventLogAdapter();
    }
}
