<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetActicityFilters extends Controller
{
    public function run()
    {
        $data  = new DictionaryData();
        $adapter = new DictionaryAdapter();
        $item = $data->getDictionaries('activity_filter');
        $arr = [];
        foreach ($item as $k => $v) {
            $arr[] = $adapter->getDataContract($v);
        }
        $this->Success($arr);
    }
}
