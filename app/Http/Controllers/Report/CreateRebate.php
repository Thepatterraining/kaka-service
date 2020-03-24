<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportSumsDayData as ReportDayData;
use App\Http\Adapter\Report\ReportSumsDayAdapter as ReportDayAdapter;
use App\Data\Sys\RebateData;

class CreateRebate extends Controller
{
    protected $validateArray=[
        "reportNo"=>"required",
    ];

    protected $validateMsg = [
        "reportNo.required"=>"请输入报表单号!",
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
        $reportNo = $request['reportNo'];

        $data = new RebateData;

        $data->createRebate($reportNo);
        
        $this->Success(true);

    }
}
