<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Report\ReportSumsDayData;


class ReportReTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
                //$this->assertTrue(true);
                dump("Settlement Test Begin.");
        
        
        $datafac = new ReportSumsDayData();
        
        //$datafac->makeAllUserHourSettlement();

            $dateStr = '2017-4-6 00:00:00';
        
        
            $start = date_create($dateStr);
        
        
         //dump($start);
            $end = $start ;
            date_add($end, date_interval_create_from_date_string("1 day"));
            $start = date_create($dateStr);
            //dump($start);
            //dump($end);
            //$str = "$start->date $end->date";
            //dump($str);
      
                //$datafac->makeAllUserDaySettlement();
        $this->assertTrue(true);        
        $datafac->makeReport('2017-6-6', '2017-6-7', "CYC02");

        /*$datafac = new CashSettlementData();
        $datafac->makeSettlement('2017-3-1','2017-4-1',2);

        $datafac = new SysCashSettlementData();
        $datafac->makeSettlement('2017-3-1','2017-4-1',2);*/
        //$datafac->makeAllReportSettlement();
    }
}
