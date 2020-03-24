<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Cash\RechargeData;
use App\Mail\JobReport;
use Mail;
use app\Data\Schedule\ScheduleJob;

class EmailTest extends TestCase
{
    public function test()
    {
        // $param = (object)[
        //     "query"=>$queryfilter,
        //     "map"=>$map
        // ];
        // $query = json_encode( $param , JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        // $url="admin/report/day/user";
        // $scheduleJob=new ScheduleJob();
        // $scheduleJob->addReportJob($url,$query);
    }
}