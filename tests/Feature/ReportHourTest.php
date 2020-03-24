<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Report\ReportSumsHourData;

use App\Data\User\UserData;

class ReportHourTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

                  $dateStr = '2017-4-6 00:00:00';
        
        
            $start = date_create($dateStr);
            $end = date_create($dateStr);
        
        
        
            $i = 0;
            // $datafac = new ReportSumsHourData();
        
             //$datafac->makeSettlement("2017-04-06 0:00:00","2017-04-07 0:00:00","CYC01");
        
        while($i<68*24){
            dump("Begin.");
            date_add($end, date_interval_create_from_date_string("1 hours"));
            dump($start);
            dump($end);


            /* $userFac = new UserData();
        
            $pageSize = 100;
            $pageIndex = 1;
            $result = $userFac->query([],$pageSize,$pageIndex);
            while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
            */        
            //         $datafac->makeReport(
            //     date_format($start,"Y-m-d H:00:00"),
            //     date_format($end,"Y-m-d H:00:00"),
            //    "CYC01");     
            //}
            /*     $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
            }
            */
            date_add($start, date_interval_create_from_date_string("1 hours"));
        
            $i++;
    
        }
    
        $this->assertTrue(true);
    }
}
