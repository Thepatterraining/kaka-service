<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Settlement\UserCashSettlementData;
use App\Data\Settlement\CashSettlementData;
use App\Data\Settlement\SysCashSettlementData;

class SettementTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //        $this->assertTrue(true);
        //        dump("Settelment Test Begin.");
        //
        //
        //$datafac = new UserCashSettlementData();
        //
        //$datafac->makeAllUserHourSettlement();

        //    $dateStr = '2017-3-28 00:00:00';
        //
        //
        //    $start = date_create($dateStr);
        //
        //
        //
        //    $end = $start ;
        //    date_add($end,date_interval_create_from_date_string("1 hours"));
        //
        //
        //    $str = "{$start}->{$end}";
        //    dump($str);
      
        //        $datafac->makeAllUserDaySettlement();
        /*
         $datafac->makeSettlement('2017-3-1','2017-4-1',190);

        $datafac = new CashSettlementData();
        $datafac->makeSettlement('2017-3-1','2017-4-1',2);

        $datafac = new SysCashSettlementData();
        $datafac->makeSettlement('2017-3-1','2017-4-1',2);*/
    }
}
