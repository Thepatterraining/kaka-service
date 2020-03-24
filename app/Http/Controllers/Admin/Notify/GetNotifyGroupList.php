<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\NotifyGroupData;
use App\Http\Adapter\Notify\NotifyGroupAdapter;

class GetNotifyGroupList extends QueryController
{
    public function getData()
    {
        return new  NotifyGroupData();
    }

    public function getAdapter()
    {
        return new NotifyGroupAdapter();
    }
}
