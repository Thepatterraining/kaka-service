<?php
namespace App\Http\Controllers\Dic;

use App\Http\Controllers\Controller;

use App\Http\HttpLogic\DictionaryLogic;

class NewsPush extends Controller
{
    protected function run()
    {
        $logic = new DictionaryLogic();
        $item = $logic->getNewpushType();
        $this->Success($item);
    }
}
