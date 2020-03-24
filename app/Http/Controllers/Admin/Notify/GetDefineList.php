<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QueryController;
use App\Data\Notify\DefineData;
use App\Http\Adapter\Notify\DefineAdapter;

class GetDefineList extends QueryController
{
    public function getData()
    {
        return new  DefineData();
    }

    public function getAdapter()
    {
        return new DefineAdapter();
    }
}
