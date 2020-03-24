<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\NewsData;
use App\Http\Adapter\Sys\NewsAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetSysNewsList extends QueryController
{

    public function getData()
    {
        return new  NewsData();
    }

    public function getAdapter()
    {
        return new NewsAdapter();
    }
}
