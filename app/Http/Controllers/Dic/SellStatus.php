<?php
namespace App\Http\Controllers\Dic;

use App\Http\Controllers\Controller;

use App\Http\HttpLogic\DictionaryLogic;

class SellStatus extends Controller
{
    protected function run()
    {
        $logic = new DictionaryLogic();
        $item = $logic->getSellStatus();
        $this->Success($item);
    }
}
