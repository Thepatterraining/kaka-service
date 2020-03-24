<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetActiviItemType extends Controller
{
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();
        $info = $data->getDictionaries('activity');
        $arr = [];
        foreach ($info as $k => $v) {
            $arr[] = $adapter->getDataContract($v);
        }
        $this->Success($arr);
    }
}
