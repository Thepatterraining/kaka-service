<?php

namespace App\Http\Controllers\Admin\Resource;

use App\System\Resource\Data\ResourceStoreData;
use App\Http\Adapter\Activity\ResourceStoreAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetResourcerStoreList extends QueryController
{

    public function getData()
    {
        return new  ResourceStoreData();
    }

    public function getAdapter()
    {
        return new ResourceStoreAdapter();
    }
}
