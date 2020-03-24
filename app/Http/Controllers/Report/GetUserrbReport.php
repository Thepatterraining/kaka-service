<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Sys\UserData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;

class GetUserrbReport extends Controller
{
    protected $validateArray=[
        // "pageSize"=>"required",
        // "pageIndex"=>"required",
    ];

    protected $validateMsg = [
        // "pageSize.required"=>"请输入每页数量!",
        // "pageIndex.required"=>"请输入页码!",
    ];

    /**
     * 管理员查询用户返佣日报列表
     *
     * @param   $pageSize
     * @param   $pageIndex
     * @author  liu
     * @version 0.1
     * @date    2017.6.15
     */
    //
    protected function run()
    {
        $request = $this->request->all();
        // $pageSize = $request['pageSize'];
        // $pageIndex = $request['pageIndex'];

         $data = new ReportUserrbSubDayData();
         $userData=new UserData();
        // $adapter = new ReportUserrbSubDayAdapter();

        // $filter = $adapter->getFilers($request);
        // $items = $data->query($filter, $pageSize, $pageIndex,
        // ["report_end"=>"desc","report_rbbuy_result"=>"desc","report_resultbuy"=>"desc"]);
    
        //$date=date("Y-m-d");
        $date="2017-6-23 0:00:00";
        $date=date_create($date);
        date_add($date, date_interval_create_from_date_string("-1 days"));
        $items=$data->getAllUncheckTop($date);
        while(empty($items))
        {
            date_add($date, date_interval_create_from_date_string("-1 days"));
            $items=$data->getAllUncheckTop($date);
        }

        $res = [];
        if (count($items) > 0) {
            foreach ($items as $val) {
                $userInfo=$userData->getUser($val->report_user);
                if(!empty($userInfo)) {
                    $val['userName']=$userInfo->user_name;
                    $val['mobile']=$userInfo->user_mobile;
                }
                $res[] = $val;
            }
        }

         $items['items'] = $res;

        $this->Success($items);

    }
}
