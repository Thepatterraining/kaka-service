<?php
namespace App\Http\Controllers\Dic;

use App\Http\Controllers\Controller;

use App\Http\HttpLogic\DictionaryLogic;

class BuyStatus extends Controller
{
    protected function run()
    {
        $logic = new DictionaryLogic();
        $item = $logic->getBuyStatus();
        $this->Success($item);
    }
}
