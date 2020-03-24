<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\StorageData;
use App\Http\Adapter\Activity\StorageAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetUserActivityList extends QueryController
{

    public function getData()
    {
        return new  StorageData();
    }

    public function getAdapter()
    {
        return new StorageAdapter();
    }
}
