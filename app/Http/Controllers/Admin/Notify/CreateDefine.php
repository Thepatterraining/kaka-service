<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\DefineData;

class CreateDefine extends Controller
{
    protected $validateArray=[
        "name"=>"required",
        "type"=>"required",
        "level"=>"required",
    ];

    protected $validateMsg = [
        "name.required"=>"请输入事件定义名称",
        "type.required"=>"请输入事件类型",
        "level.required"=>"请输入事件优先级"
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $name=$requests["name"];
        $type=$requests["type"];
        $level=$requests["level"];

        if(array_key_exists("key", $requests)) {
            $key=$requests["key"];
        }
        else
        {
            $key=null;
        }

        if(array_key_exists("model", $requests)) {
            $model=$requests["model"];
        }
        else
        {
            $model=null;
        }

        if(array_key_exists("filter", $requests)) {
            $filter=$requests["filter"];
        }
        else
        {
            $filter=null;
        }

        if(array_key_exists("queuetype", $requests)) {
            $queueType=$requests["queuetype"];
        }
        else
        {
            $queueType=null;
        }
        
        if(array_key_exists("observer", $requests)) {
            $observer=$requests["observer"];
        }
        else
        {
            $observer=null;
        }

        $data = new DefineData();
        $define=$data->getDefineByName($name);
        if(empty($define)) {
            $data->addDefine($name, $key, $model, $type, $filter, $level, $queueType, $observer);
        }
        return $this->Success();
    }
}
