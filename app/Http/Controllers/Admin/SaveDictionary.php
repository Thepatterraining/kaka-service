<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveDictionary extends Controller
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
     * 修改字典表
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
        $adapter = new DictionaryAdapter();
        $dicInfo = $adapter->getData($this->request);
        $model = $data->getDictionary($type, $no);
        $adapter->saveToModel(false, $dicInfo, $model);
        $data->save($model);
        $this->Success('修改成功');
    }
}
