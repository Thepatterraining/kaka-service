<?php

namespace App\Http\Controllers\Admin\Region;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSubwaystations extends QueryController
{
    public function getData()
    {
        return new \App\Data\Region\SubwaystationData;
    }

    public function getAdapter()
    {
        return new \App\Http\Adapter\Region\SubwaystationAdapter;
    }
}
