<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\User\UserRebateRankdayData;

use App\Data\User\UserData;

class ReportRbbHourTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

            $dateStr = '2017-6-22 00:00:00';
        
        
            $start = date_create($dateStr);
            $end = date_create($dateStr);
        
        
        
            $i = 0;
            $datafac = new UserRebateRankDayData();
        
             //$datafac->makeSettlement("2017-04-06 0:00:00","2017-04-07 0:00:00","CYC01");
        
        //while($i<68*24){
        dump("Begin.");
        date_add($end, date_interval_create_from_date_string("1 day"));



        /* $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
        */   
        //$userData=new UserData();
        //$userId=$userData->getAllId();
        //for($id=1;$id<1905;$id++)
        //{
            dump($start);
            dump($end);
            //dump($id);
            //     $datafac->saveRank(
            // date_format($start,"Y-m-d 0:00:00")); 
            // $datafac->makeAllDayReport();    
        //}
            //}
        /*     $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        */
        //date_add($start,date_interval_create_from_date_string("1 day"));
        
        // $i++;
    
        // }
    
        $this->assertTrue(true);
    }
}
