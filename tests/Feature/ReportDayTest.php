<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Report\ReportTradeDayData;
use App\Data\Report\ReportWithdrawalDayData;
use App\Data\Report\ReportRechargeDayData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Report\ReportRechargeItemDayData;

use App\Data\User\UserData;

class ReportDayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        //         $dateStr = '2017-4-7 00:00:00';
        
        
        //         $start = date_create($dateStr);
        //         $end = date_create($dateStr);
       
        
        
        //         $i = 0;
        //         $datafac = new ReportUserrbSubDayData();
        //         //$datafac->makeAllDayReport();
        //          //$datafac->makeSettlement("2017-04-06 0:00:00","2017-04-07 0:00:00","CYC01");
        
        //    // while($i<69){
        //         dump("Begin.");
        //         date_add($end,date_interval_create_from_date_string("1 day"));
        //         dump($start);
        //         dump($end); 

        //         $userFac = new UserData();

        //      //   $pageSize = 100;
        //     //    $pageIndex = 1;
        //         $result = $userFac->query([],$pageSize,$pageIndex);
        //         while($pageIndex<=($result["pageCount"])){  
        //         foreach($result["items"] as $resultitem){
                
        //             $datafac->createReport(
        //             date_format($start,"Y-m-d H:00:00"),
        //             date_format($end,"Y-m-d H:00:00"),
        //             "CYC01");     
        //         //    $datafac->makeReport("RUR2017070315112107465",3);
        //        // }
        //     //   $pageIndex ++;
        //      //   $result = $userFac->query([],$pageSize,$pageIndex);   
        //     //}
      
        //     date_add($start,date_interval_create_from_date_string("1 day"));
        
        //   //  $i++;
    
        //   //  }
        
        //     $this->assertTrue(true);
    }
}
