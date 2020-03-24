<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;

class CreateNotifyGroup extends Controller
{
    protected $validateArray=[
        "defineid"=>"required",
        "groupid"=>"required",
    ];

    protected $validateMsg = [
        "defineid.required"=>"请输入通知id",
        "groupid.required"=>"请输入通知组id",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $difineId=$requests["defineid"];
        $groupId=$requests["groupid"];
        $data = new NotifyGroupData();
        $set=$data->getSet($difineId, $groupId);
        if(empty($set)) {
            $data->addNotifyGroup($difineId, $groupId); 
        }
        return $this->Success();
    }
}
