<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportSumsDayData as ReportDayData;
use App\Http\Adapter\Report\ReportSumsDayAdapter as ReportDayAdapter;
use App\Data\Sys\RebateData;

class ConfirmRebate extends Controller
{
    protected $validateArray=[
        "reportNo"=>"required",
        "confirm"=>"required|boolean",
    ];

    protected $validateMsg = [
        "reportNo.required"=>"请输入报表单号!",
        "confirm.required"=>"请输入true and false!",
        "confirm.boolean"=>"请输入布尔值!",
    ];

    /**
     * 审核返佣
     *
     * @param $reportNo 报表单号
     * @param $confirm true and false
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        $reportNo = $request['reportNo'];
        $confirm = $request['confirm'];

        $data = new RebateData;

        if ($confirm) {
            $data->rebateTrue($reportNo);
        } else {
            $data->rebateFalse($reportNo);
        }
        
        
        $this->Success(true);

    }
}
