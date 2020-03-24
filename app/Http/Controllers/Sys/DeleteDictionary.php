<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteDictionary extends Controller
{
    //
    public function run()
    {
        $data = new DictionaryData();
        $id = $this->request->input("id");
        $item = $data->delete($id);
        return $this->success($item);
    }
}
