<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\NotifyUserLogData;
use App\Http\Adapter\Notify\NotifyUserLogAdapter;

class GetNotifyUserLogList extends QueryController
{
    public function getData()
    {
        return new NotifyUserLogData();
    }

    public function getAdapter()
    {
        return new NotifyUserLogAdapter();
    }
}
