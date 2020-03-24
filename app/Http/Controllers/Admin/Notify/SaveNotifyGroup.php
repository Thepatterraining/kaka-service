<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;
use App\Http\Adapter\Notify\NotifyGroupAdapter;

class SaveNotifyGroup extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
        "data.name"=>"required",
        "data.note"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知组id",
        "id.exists"=>"通知组id不存在!",
        "data.name.required"=>"请输入通知组名称",
        "data.note.required"=>"请输入通知组类型",
    ];

    public function run()
    {
        $id = $this->request->input('id');

        $data = new NotifyGroupData;
        $adapter = new NotifyGroupAdapter;
        
        $group = $data->get($id);
        
        $info = $adapter->getData($this->request);
        $adapter->saveToModel(false, $info, $group);
        $data->save($group);

        $auth = $adapter->getDataContract($group);


        return $this->Success($auth);

    }
}
