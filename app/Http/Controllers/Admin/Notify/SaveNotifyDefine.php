<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyDefineData;
use App\Http\Adapter\Notify\NotifyDefineAdapter;

class SaveNotifyDefine extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
        "data.name"=>"required",
        "data.event"=>"required",
        "data.level"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知定义id",
        "id.exists"=>"通知定义id不存在!",
        "data.name.required"=>"请输入通知定义名称",
        "data.event.required"=>"请输入通知定义事件",
        "data.level.required"=>"请输入通知定义优先级",
    ];

    public function run()
    {
        $id = $this->request->input('id');

        $data = new NotifyDefineData;
        $adapter = new NotifyDefineAdapter;
        
        $define = $data->get($id);
        
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $define);
        $data->save($define);

        $auth = $adapter->getDataContract($define);

        return $this->Success($auth);
    }
}
