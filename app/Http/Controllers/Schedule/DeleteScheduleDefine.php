<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Schedule\ScheduleDefineData;

class DeleteScheduleDefine extends Controller
{
    protected $validateArray=[
        "schNo"=>"required",
    ];

    protected $validateMsg = [
        "schNo.required"=>"请输入报表简称!",
    ];

    /**
     * 发起返佣
     *
     * @param $reportNo 报表单号
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $schName = $request['schNo'];

        $data = new ScheduleDefineData;

        $data->deleteScheduleDefine($schNo);
        
        $this->Success(true);

    }
}
