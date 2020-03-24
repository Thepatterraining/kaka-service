<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetDictionary extends Controller
{
    //
    public function run()
    {
        $adapter = new DictionaryAdapter();
        $data = new DictionaryData();

        $id = $this->request->input("id");
        $item = $data->get($id);
        $result = $adapter->getDataContract($item);
        return $this->success($result);
    }
}
