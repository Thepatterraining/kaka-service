<?php

namespace App\Http\Controllers\Admin;

use App\Data\Sys\DictionaryData;
use App\Http\Adapter\Sys\DictionaryAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddDictionary extends Controller
{
    protected $validateArray=array(
        "data.no"=>"required",
        "data.name"=>"required",
        "data.type"=>"required",
    );

    protected $validateMsg = [
        "data.no.required"=>"请输入no!",
        "data.name.required"=>"请输入name！",
        "data.type.required"=>"请输入type！",
    ];

    /**
     * 添加字典表数据
     *
     * @param   $data 数据
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $data = new DictionaryData();
        $adapter = new DictionaryAdapter();

        $dicInfo = $adapter->getData($this->request);
        $model = $data->newitem();
        $adapter->saveToModel(false, $dicInfo, $model);

        $data->save($model);

        $this->Success('添加成功');
    }
}
