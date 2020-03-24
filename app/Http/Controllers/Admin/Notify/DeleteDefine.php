<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\DefineData;
use App\Data\Notify\NotifyDefineData;

class DeleteDefine extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_define,id",
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
        $difineData=new NotifyDefineData();
        $info=$defineData->getNotifyInfo($id);

        if($info->isEmpty()) {
            $data->delete($id);
        }
        
        return $this->Success();
    }
}
