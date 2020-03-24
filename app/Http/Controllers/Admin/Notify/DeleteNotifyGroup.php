<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;
use App\Data\Notify\NotifyGroupMemberData;

class DeleteNotifyGroup extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知组id",
        "id.exists"=>"通知组id不存在!",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $data = new NotifyGroupData();
        $memberData=new NotifyGroupMemberData();
        $info=$memberData->getUserByGroup($id);

        if($info->isEmpty()) {
            $data->delete($id);
        }

        return $this->Success();
    }
}
