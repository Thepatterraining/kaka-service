<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupSetData;

class DeleteNotifyGroupSet extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroupset,id",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入关联id",
        "id.exists"=>"关联id不存在!",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $data = new NotifyGroupSetData();

        $data->delete($id);

        return $this->Success();
    }
}
