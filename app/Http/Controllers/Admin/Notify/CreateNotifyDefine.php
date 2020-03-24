<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyDefineData;

class CreateNotifyDefine extends Controller
{
    protected $validateArray=[
        "name"=>"required",
        "event"=>"required",
        "type"=>"required",
        "level"=>"required",
        "filter"=>"required"
    ];

    protected $validateMsg = [
        "name.required"=>"请输入通知定义名称",
        "event.required"=>"请输入通知定义关联事件编号",
        "type.required"=>"请输入通知类型",
        "level.required"=>"请输入通知优先级",
        "filter.required"=>"请输入通知查询条件"
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $name=$requests["name"];
        $event=$requests["event"];
        $type=$requests["type"];
        $level=$requests["level"];

        if(array_key_exists("filter", $requests)) {
            $filter=$requests["filter"];
        }
        else
        {
            $filter=null;
        }

        if(array_key_exists("specialclass", $requests)) {
            $specialclass=$requests["specialclass"];
        }
        else
        {
            $specialclass=null;
        }

        if(array_key_exists("fmt", $requests)) {
            $fmt=$requests["fmt"];
        }
        else
        {
            $fmt=null;
        }

        $data = new NotifyDefineData();
        $define=$data->getDefine($name);
        if(empty($define)) {
            $data->addNotifyDefine($name, $event, $filter, $type, $specialclass, $level, $fmt);
        }
        return $this->Success();
    }
}
