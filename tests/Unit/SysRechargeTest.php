<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Tests\Unit\TestModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Data\Cash\SysRechargeData;
use  App\Mail\Report;

class SysRechargeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $sysRecharge = new SysRechargeData;
        $sysRecharge->DealTimeoutThirdRechargeData();
       
    }
}
