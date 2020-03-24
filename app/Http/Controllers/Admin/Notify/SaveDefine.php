<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\DefineData;
use App\Http\Adapter\Notify\DefineAdapter;

class SaveDefine extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
        "data.name"=>"required",
        "data.key"=>"required",
        "data.model"=>"required",
        "data.level"=>"required",
        "data.type"=>"required",
        "data.filter"=>"required",
        "data.queuetype"=>"required",
        "data.observer"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知定义id",
        "id.exists"=>"通知定义id不存在!",
        "data.name.required"=>"请输入事件定义名称",
        "data.key.required"=>"请输入事件定义key",
        "data.model.required"=>"请输入事件定义类",
        "data.level.required"=>"请输入事件定义优先级",
        "data.type.required"=>"请输入事件类型",
        "data.filter"=>"请输入事件处理条件",
        "data.queuetype"=>"请输入事件所属队列类型",
        "data.observer"=>"请输入事件观察类",
    ];

    public function run()
    {
        $id = $this->request->input('id');

        $data = new DefineData;
        $adapter = new DefineAdapter;
        
        $define = $data->get($id);
        
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $define);
        $data->save($define);

        $auth = $define->getDataContract($define);

        return $this->Success($auth);
    }
}
