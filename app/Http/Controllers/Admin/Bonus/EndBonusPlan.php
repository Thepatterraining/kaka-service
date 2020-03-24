<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Bonus\ProjBonusPlanData;

class EndBonusPlan extends Controller
{
    protected $validateArray=[
        "no"=>"required|doc:bonusPlan",
    ];
 
    protected $validateMsg = [
        "no.required"=>"请输入计划单号!",
    ];

    /**
     * 终止分红计划
     *
     * @author zhoutao
     * @date   2017.11.8
     */
    protected function run()
    {
        $request = $this->request->all();
        $planNo = $request['no'];

        $data = new ProjBonusPlanData;

        $data->saveStatus($planNo, ProjBonusPlanData::COMPLETED_STATUS);
        
        $this->Success();

    }
}
