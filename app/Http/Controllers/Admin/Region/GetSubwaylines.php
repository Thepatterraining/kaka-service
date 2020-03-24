<?php

namespace App\Http\Controllers\Admin\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSubwaylines extends QueryController
{
    public function getData()
    {
        return new \App\Data\Region\SubwaylineData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Region\SubwaylineAdapter;
    }
}
