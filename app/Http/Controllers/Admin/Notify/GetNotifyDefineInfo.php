<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyDefineData;
use App\Http\Adapter\Notify\NotifyDefineAdapter;

class GetNotifyDefineInfo extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifydefine,id",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知组id",
        "id.exists"=>"通知组id不存在"
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $data = new NotifyDefineData();
        $adapter=new NotifyDefineAdapter();

        $res=$data->get($id);
        $res=$adapter->getDataContract($res);

        return $this->Success($res);
    }
}
