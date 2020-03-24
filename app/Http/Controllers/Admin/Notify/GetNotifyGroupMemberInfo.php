<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Adapter\Notify\NotifyGroupAdapter;
use App\Http\Adapter\Notify\NotifyGroupMemberAdapter;
use App\Data\Notify\NotifyGroupData;
use App\Data\Notify\NotifyGroupMemberData;

class GetNotifyGroupMemberInfo extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_notifygroup,id",
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
        $data = new NotifyGroupMemberData();
        $adapter=new NotifyGroupMemberAdapter();
        
        $res=array();

        $users=$data->getUserByGroup($id);
        if(!$users->isEmpty()) {
            foreach($users as $user){
                $items=$adapter->getDataContract($user);
                $res[]=$items;
            }
        }
        
        return $this->Success($res);
    }
}
