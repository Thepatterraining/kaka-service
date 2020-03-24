<?php
namespace App\Http\Controllers\Sys;

use App\Data\Sys\LoginLogData;
use App\Http\Adapter\Sys\LoginLogAdapter;
use App\Http\Controllers\QueryController;

class QueryLoginlog extends QueryController
{

    function getData()
    {
        return new LoginLogData();
    }

    function getAdapter()
    {
        return new LoginLogAdapter();
    }
}
