<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteDictionary extends Controller
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
     * 删除字典表
     *
     * @param   $no no
     * @param   $type type
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $request = $this->request->all();
        $no = $request['no'];
        $type = $request['type'];
        $data = new DictionaryData();
        $data->delDic($no, $type);
        $this->Success('删除成功');
    }
}
