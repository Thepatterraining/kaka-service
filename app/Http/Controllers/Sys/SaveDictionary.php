<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveDictionary extends Controller
{
    //
    protected function run()
    {

        $adapter = new DictionaryAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new DictionaryData();


        $model = $datafac->get($item['id']);

        $adapter->saveToModel(false, $item, $model);

        $datafac->save($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
