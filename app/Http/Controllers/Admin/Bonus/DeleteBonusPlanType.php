<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusPlanTypeData;

class DeleteBonusPlanType extends Controller
{
    protected $validateArray=[
        "id"=>"required",
    ];

    protected $validateMsg = [
        "id.required"=>"请输入计划类型id!",
    ];

    /**
     * 删除分红计划类型
     *
     * @author zhoutao
     * @date   2017.11.8
     */
    protected function run()
    {
        $request = $this->request->all();
        $typeid = $request['id'];

        $data = new ProjBonusPlanTypeData;

        $data->delete($typeid);
        
        $this->Success();

    }
}
