<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Schedule\ScheduleItemData;
use App\Data\Activity\InvitationData;
use App\Data\Report\ReportUserrbSubDayData;

class ReportUserrbSubDayDataTest extends TestCase
{
    public function testExample()
    {

        $reportUserrbSubDayData=new ReportUserrbSubDayData();
        // $scheduleItemData->createJob();
        $model=$reportUserrbSubDayData->newitem();
        $res=$model->where('report_start', '2017-6-29')->get();
        foreach($res as $value)
        {
            $value->report_rbbuy_totalresult=$value->report_rbbuy_result;
            $value->save();
        }
        return true;
    }
}