<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;
use App\Http\Adapter\Notify\NotifyGroupAdapter;

class SaveNotifyGroupSet extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
        "data.defineid.required"=>"请输入通知id",
        "data.groupid.required"=>"请输入通知组id",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入关联id",
        "id.exists"=>"关联id不存在!",
        "data.defineid.required"=>"请输入通知id",
        "data.groupid.required"=>"请输入通知组id",
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
