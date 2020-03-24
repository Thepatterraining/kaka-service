<?php

namespace App\Http\Controllers\Admin\Resource;

use App\System\Resource\Data\ResourceIndexData;
use App\Http\Adapter\Activity\ResourceIndexAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetResourceIndexList extends QueryController
{

    public function getData()
    {
        return new  ResourceIndexData();
    }

    public function getAdapter()
    {
        return new ResourceIndexAdapter();
    }
}
