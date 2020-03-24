<?php

namespace App\Http\Controllers\Admin\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetDistricts extends QueryController
{
    public function getData()
    {
        return new \App\Data\Region\DistrictData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Region\DistrictAdapter;
    }
}
