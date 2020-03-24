<?php

namespace App\Http\Controllers\Admin\Schedule;;

use App\Data\Schedule\ScheduleDefineData;
use App\Http\Adapter\Schedule\ScheduleDefineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetScheduleDefineInfo extends Controller
{
    protected $validateArray=array(
        "schname"=>"required",
        //"schtype"=>"required",
    );

    protected $validateMsg = [
        "schname.required"=>"请输入定义名称!",
        // "path.required"=>"请输入路径！",
        //"schtype"=>"请输入类型！"
    ];

    /**
     * 修改配置路径
     *
     * @param   schno
     * @author  liu
     * @version 0.1
     * @date    2017.4.12
     */

    public function run()
    {
        $request = $this->request->all();
        $schName = $this->request->input('schname');
        $schType = $this->request->input('schtype');

        $data = new ScheduleDefineData();
        $adapter = new ScheduleDefineAdapter();

        $info = $data->getSingleScheduleDefine($schName);

        if ($info == null) {
            return $this->Error(809001);
        }
        $res = [];
        $res = $adapter->getDataContract($info);
        return $this->Success($res);
    }
}
