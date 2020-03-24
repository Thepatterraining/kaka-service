<?php

namespace App\Http\Controllers\Admin\Resource;

use App\System\Resource\Data\ResourceTypeData;
use App\Http\Adapter\Activity\ResourceTypeAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetResourcerTypeList extends QueryController
{

    public function getData()
    {
        return new  ResourceTypeData();
    }

    public function getAdapter()
    {
        return new ResourceTypeAdapter();
    }
}
