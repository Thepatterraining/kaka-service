<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\RegCofigData;
use App\Http\Adapter\Activity\RegCofigAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetActivityConfigList extends QueryController
{

    public function getData()
    {
        return new  RegCofigData();
    }

    public function getAdapter()
    {
        return new RegCofigAdapter();
    }
}
