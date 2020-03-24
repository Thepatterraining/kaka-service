<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusPlanTypeData;

class CreateBonusPlanType extends Controller
{
    protected $validateArray=[
        "typeName"=>"required",
        "typeNote"=>"required",
        "typeStatus"=>"required",
        "typeExp"=>"required",
    ];

    protected $validateMsg = [
        "typeName.required"=>"请输入计划类型名称!",
        "typeNote.required"=>"请输入计划类型说明!",
        "typeStatus.required"=>"请输入计划类型状态!",
        "typeExp.required"=>"请输入计划类型表达式!",
    ];

    /**
     * 创建分红计划类型
     *
     * @author zhoutao
     * @date   2017.11.8
     */
    protected function run()
    {
        $request = $this->request->all();
        $typeName = $request['typeName'];
        $typeNote = $request['typeNote'];
        $typeStatus = $request['typeStatus'];
        $typeExp = $request['typeExp'];

        $data = new ProjBonusPlanTypeData;

        $data->add($typeName, $typeNote, $typeStatus, $typeExp);
        
        $this->Success();

    }
}
