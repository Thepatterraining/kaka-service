<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetDictionaryInfo extends Controller
{
    protected $validateArray=array(
        "no"=>"required",
        "type"=>"required",
    );

    protected $validateMsg = [
        "no.required"=>"请输入no!",
        "type.required"=>"请输入type！",
    ];

    /**
     * 查询详情
     *
     * @param   $no no
     * @param   $type type
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();
        $no = $this->request->input('no');
        $type = $this->request->input('type');
        $item = $data->getDictionary($type, $no);
        $res = $adapter->getDataContract($item);
        return $this->Success($res);
    }
}
