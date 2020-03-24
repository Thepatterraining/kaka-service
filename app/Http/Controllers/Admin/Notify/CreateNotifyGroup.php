<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\NotifyGroupData;

class CreateNotifyGroup extends Controller
{
    protected $validateArray=[
        "name"=>"required",
        "note"=>"required",
    ];

    protected $validateMsg = [
        "name.required"=>"请输入活动分组名称",
        "note.required"=>"请输入活动分组类型",
    ];

    public function run()
    {
        $request = $this->request;
        $requests = $request->all();

        $name=$requests["name"];
        $note=$requests["note"];
        $data = new NotifyGroupData();
        $group=$data->getGroup($name);
        if(empty($group)) {
            $data->addNotifyGroup($name, $note);
        }
        return $this->Success();
    }
}
