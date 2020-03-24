<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Schedule\ScheduleDefineData;

class AddScheduleDefine extends Controller
{
    protected $validateArray=[
        "schName"=>"required",
        "path"=>"required",
        "name"=>"required",
        "schType"=>"required",
    ];

    protected $validateMsg = [
        "schName.required"=>"请输入报表名称!",
        "path.required"=>"请输入报表路径!",
        "name.required"=>"请输入报表简称!",
        "schType.required"=>"请输入报表周期类型!",
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
        $schName = $request['schName'];
        $path = $request['path'];
        $name = $request['name'];
        $schType = $request['schType'];

        $data = new ScheduleDefineData;

        $data->createScheduleDefine($schName, $path, $name, $schType);
        
        $this->Success(true);

    }
}
