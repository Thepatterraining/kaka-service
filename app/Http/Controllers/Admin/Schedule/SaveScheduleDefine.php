<?php

namespace App\Http\Controllers\Admin\Schedule;;

use App\Data\Schedule\ScheduleDefineData;
use App\Http\Adapter\Schedule\ScheduleDefineAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveScheduleDefine extends Controller
{
    protected $validateArray=array(
        // "schname"=>"required",
        // "path"=>"required",
        "schtype"=>"required",
        "no"=>"required"
    );

    protected $validateMsg = [
        // "schname.required"=>"请输入定义名称!",
        // "path.required"=>"请输入路径！",
        "schtype"=>"请输入类型！",
        "no"=>"请输入命名规则！"
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
        $path = $this->request->input('path');
        $no = $this->request->input('no');
        $schType = $this->request->input('schtype');

        $data = new ScheduleDefineData();
        $adapter = new ScheduleDefineAdapter();

        $info = $data->getSingleScheduleDefineBySchNo($no);

        if ($info == null) {
            return $this->Error(809001);
        }

        if($path!=null) {
            $info->sch_jobclass="\App\Data".$path;
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
        }

        if($schName!=null) {
            $info->sch_name=$schName;
            $info->sch_namestr=$schName;  
        }
        $res = $data->save($info);
        return $this->Success($res);
    }
}
