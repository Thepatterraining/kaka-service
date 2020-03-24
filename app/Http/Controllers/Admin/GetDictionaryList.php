<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\QueryController;

class GetDictionaryList extends QueryController
{

    public function getData()
    {
        return new  DictionaryData();
    }

    public function getAdapter()
    {
        return new DictionaryAdapter();
    }
}
