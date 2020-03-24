<?php

namespace App\Http\Controllers\Admin;

use App\Data\Item\InfoData;
use App\Http\Adapter\Coin\ItemAdapter;
use App\Http\Adapter\Item\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetItemList extends QueryController
{
    public function getData()
    {
        return new  InfoData();
    }

    public function getAdapter()
    {
        return new InfoAdapter();
    }
}
