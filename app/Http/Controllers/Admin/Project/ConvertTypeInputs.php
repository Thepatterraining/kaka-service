<?php

namespace App\Http\Controllers\Admin\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Project\ProjectTypeInputData;

class ConvertTypeInputs extends Controller
{
    protected $validateArray=[
        // "typeid"=>"required",
        // "data.limittype"=>"required|dic:activity_limit",
        // "data.start"=>"required",
        // "data.end"=>"required",
        // "data.limitcount"=>"required|integer",
    ];

    protected $validateMsg = [
        // "typeid.required"=>"请输入typeid",
    ];

    /**
     * 添加现金券
     *
     * @param   $name 活动名称
     * @param   $limittype 类型
     * @param   $start 开始时间
     * @param   $end 结束时间
     * @param   $limitcount 数量
     * @param   $status 状态
     * @param   $count 实际数量
     * @param   $filter 事件
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $inputs = $this->request->all();
        
        $projectTypeInputData = new ProjectTypeInputData;
        $projectTypeInputData->ConvertTypeInputs($inputs);

        $this->Success();
    }
}
