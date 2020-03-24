<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Http\Adapter\Activity\InfoAdapter;
use App\Http\Controllers\QueryController;

class GetActivityList extends QueryController
{
    public function getData()
    {
        return new  InfoData();
    }

    public function getAdapter()
    {
        return new InfoAdapter();
    }
}
