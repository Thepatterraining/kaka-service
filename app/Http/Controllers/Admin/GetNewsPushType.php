<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetNewsPushType extends Controller
{
    /**
     * 查询公告推送类型
     *
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.26
     */
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();
        $info = $data->getDictionaries('newspush');
        $arr = [];
        foreach ($info as $k => $v) {
            $arr[] = $adapter->getDataContract($v);
        }
        $this->Success($arr);
    }
}
