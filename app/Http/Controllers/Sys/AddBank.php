<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Sys\BankData;
use App\Http\Adapter\Sys\BankAdapter;

class AddBank extends Controller
{
 
    
    protected function run()
    {

        $adapter = new BankAdapter();
        $item = $adapter->getItem($this->request);
        $datafac = new BankData();
        $model = $datafac->newitem();
        $adapter->saveToModel(false, $item, $model);

        $datafac->create($model);
        $item = $adapter->getDataContract($model);

        $this->Success($item);
    }
}
