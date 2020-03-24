<?php
namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use App\Data\Auth\UserData;

use App\Data\Schedule\ScheduleJob;
use Illuminate\Support\Facades\Log;

class MakeReport extends Controller
{


    protected function run()
    {
        $request = $this->request->all();
      
        $userID = $this->session->userid;

        $userFac = new UserData();
        $userInfo = $userFac->getByNo($userID);

        $name= $userInfo ->auth_email;

        $JobFac = new ScheduleJob();
        $url = $this->request->url;
        $queryfilter = $this->request->queryfilter;
        $map = $this->request->map;
      
        $param = (object)[
            "query"=>$queryfilter,
            "map"=>$map
        ];
        $param = json_encode($param, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        $no = $JobFac->addReportJob($url, $param);
        $this->Success("您好,您订制的报表编号为{$no},稍后将发送到{$name},请注意查收");

    }

}