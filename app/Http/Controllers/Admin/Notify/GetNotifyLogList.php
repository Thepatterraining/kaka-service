<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\NotifyLogData;
use App\Http\Adapter\Notify\NotifyLogAdapter;

class GetNotifyLogList extends QueryController
{
    public function getData()
    {
        return new NotifyLogData();
    }

    public function getAdapter()
    {
        return new NotifyLogAdapter();
    }
}
