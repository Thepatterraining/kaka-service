<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\NotifyDefineData;
use App\Http\Adapter\Notify\NotifyDefineAdapter;

class GetNotifyDefineList extends QueryController
{
    public function getData()
    {
        return new  NotifyDefineData();
    }

    public function getAdapter()
    {
        return new NotifyDefineAdapter();
    }
}
