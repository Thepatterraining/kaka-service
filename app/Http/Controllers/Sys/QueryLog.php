<?php
namespace App\Http\Controllers\Sys;

use App\Data\Sys\LogData;
use App\Http\Adapter\Sys\LogAdapter;
use App\Http\Controllers\QueryController;

class QueryLog extends QueryController
{

    function getData()
    {
        return new LogData();
    }

    function getAdapter()
    {
        return new LogAdapter();
    }
}
