<?php

namespace App\Http\Controllers\Admin\Schedule;;

use App\Data\Schedule\ScheduleDefineData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteScheduleDefine extends Controller
{
    protected $validateArray=array(
        "schno"=>"required"
    );

    protected $validateMsg = [
        "schno.required"=>"请输入定义编号!"
    ];

    /**
     * 删除日程定义
     *
     * @param   $name 定义名称
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.4
     */
    public function run()
    {
        $request = $this->request->all();
        $schno = $request['schno'];
        $data = new ScheduleDefineData();
        $info=$data->getSingleScheduleDefineBySchNo($schno);
        if ($info == null) {
            return $this->Error(801010);
        }
        $data->deleteScheduleDefine($schno);
        $this->Success('删除成功');
    }
}
