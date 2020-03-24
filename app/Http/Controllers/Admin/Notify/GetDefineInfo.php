<?php

namespace App\Http\Controllers\Admin\Notify;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Notify\DefineData;
use App\Http\Adapter\Notify\DefineAdapter;

class GetDefineInfo extends Controller
{
    protected $validateArray=[
        "id"=>"required|exists:event_define,id",
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
        $data = new DefineData();
        $adapter=new DefineAdapter();

        $res=$data->get($id);
        $res=$adapter->getDataContract($res);

        return $this->Success($res);
    }
}
