<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddDictionary extends Controller
{
    //
    protected function run()
    {

        $adapter = new DictionaryAdapter();

   
        $item = $adapter->getItem($this->request);

 
        $datafac = new DictionaryData();


        $model = $datafac->newitem();

        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);

        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
