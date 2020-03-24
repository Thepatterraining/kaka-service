<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyDefineData;
// use App\Data\Notify\NotifyDefineMemberData;

class DeleteNotifyDefine extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifydefine,id",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入通知定义id",
        "id.exists"=>"通知定义id不存在!",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $id=$requests["id"];
        $data = new NotifyDefineData();
        // $memberData=new NotifyGroupMemberData();
        // $info=$memberData->getUserByGroup($id);

        // if($info->isEmpty())
        // {
            $data->delete($id);
        // }

        return $this->Success();
    }
}
