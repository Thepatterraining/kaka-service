<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Adapter\Resource\ResourcebannerpicAdapter;
use App\Http\Controllers\QueryController;
use App\Data\Resource\ResourcebannerpicData;

class GetBannerList extends QueryController
{

    public function getData()
    {
        return new ResourcebannerpicData;
    }

    public function getAdapter()
    {
        return new  ResourcebannerpicAdapter;
    }
}
