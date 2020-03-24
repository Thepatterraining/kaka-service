<?php

namespace App\Http\Controllers\Admin\Resource;

use App\System\Resource\Data\ResourceGroupData;
use App\Http\Adapter\Activity\ResourceGroupAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetResourcerGroupList extends QueryController
{

    public function getData()
    {
        return new  ResourceGroupData();
    }

    public function getAdapter()
    {
        return new ResourceGroupAdapter();
    }
}
