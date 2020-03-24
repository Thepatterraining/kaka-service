<?php

namespace App\Http\Controllers\Admin\Schedule;

use App\Data\Schedule\ScheduleDefineData;
use App\Http\Adapter\Schedule\ScheduleDefineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddScheduleDefine extends Controller
{
    protected $validateArray=array(
        "schname"=>"required",
        "path"=>"required",
        "schtype"=>"required",
        "no"=>"required"
    );

    protected $validateMsg = [
        "schname.required"=>"请输入定义名称!",
        "path.required"=>"请输入路径！",
        "schtype"=>"请输入类型！",
        "no"=>"请输入命名规则！"
    ];

    /**
     * 创建管理员
     *
     * @param   $schName
     * @param   $path
     * @param   $nameStr
     * @param   $schType
     * @author  liu
     * @version 0.1
     * @date    2017.7.3
     */
    public function run()
    {
        $request=$this->request->all();
        $schName = $this->request->input('schname');
        $path = $this->request->input('path');
        $jobClass=$info->sch_jobclass;
        if(class_exists($jobClass)==true) {
            $jobObj=new $jobClass();
            if(!method_exists($jobObj, 'run')) {
                return $this->Error(800110);
            }
        }
        else
        {
            return $this->Error(800111);
        }
        $no = $this->request->input('no');
        $schType = $this->request->input('schtype');
        $data = new ScheduleDefineData();
        $adapter = new ScheduleDefineAdapter();
        $model = $data->newitem();
        //$adapter->saveToModel(false, $userInfo, $model);
        $data->createScheduleDefine($schName, $path, $no, $schType);
        $this->Success('创建成功');
    }
}
