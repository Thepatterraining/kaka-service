<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetDictionary extends Controller
{
    protected $validateArray=[
        "type"=>"required",
    ];

    protected $validateMsg = [
        "type.required"=>"请输入字典表类型",
    ];


    /**
     * 查询字典表类型
     *
     * @param   pageSize 字典类型
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();

        $resquest = $this->request->all();
        $type = $resquest['type'];
        $item = $data->getDictionaries($type);
        $res = [];
        foreach ($item as $val) {
            $arr = $adapter->getDataContract($val, ["no","name"]);
            $res[] = $arr;
        }
        return $this->Success($res);
    }
}
