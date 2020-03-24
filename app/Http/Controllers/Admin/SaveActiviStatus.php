<?php

namespace App\Http\Controllers\Admin;

use App\Data\Activity\InfoData;
use App\Http\Adapter\Activity\InfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveActiviStatus extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:activityinfo",
        "status"=>"required|dic:activity_status",
    ];

    protected $validateMsg = [
        "status.required"=>"请输入状态",
        "no.required"=>"请输入活动编号",
    ];

    /**
     * 修改活动状态
     *
     * @param   no 活动编号
     * @param   status 活动状态
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $request = $this->request->all();
        $no = $request['no'];
        $status = $request['status'];
        $data  = new InfoData();
        $res = $data->saveStatus($no, $status);
        if ($res === false) {
            $this->Error();
        }
        $this->Success($res);
    }
}
