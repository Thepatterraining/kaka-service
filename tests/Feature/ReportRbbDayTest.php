<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Report\ReportUserCashDayData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\User\CoinAccountData;

use App\Data\User\UserData;

class ReportRbbDayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

            $dateStr = '2017-7-13 00:00:00';
        
        
            $start = date_create($dateStr);
            $end = date_create($dateStr);
       
            $lastStr='2017-7-14 0:00:00';
        
            $i = 0;
            $datafac = new ReportUserrbSubDayData();
            $coinAccountData=new CoinAccountData();
            $reportUserCoinItemData = new ReportUserCoinItemDayData();
            //$datafac->makeAllDayReport();
             //$datafac->makeSettlement("2017-04-06 0:00:00","2017-04-07 0:00:00","CYC01");
             $time=(strtotime($lastStr)-strtotime($dateStr))/86400;

        dump($time);
        while($i<$time){
            dump("Begin.");
            date_add($end, date_interval_create_from_date_string("1 day"));
            dump($start);
            dump($end); 

            $userFac = new UserData();
        
            //   $pageSize = 100;
            //    $pageIndex = 1;
            //    $result = $userFac->query([],$pageSize,$pageIndex);
            //    while($pageIndex<=($result["pageCount"])){  
            //    foreach($result["items"] as $resultitem){
            $userData2=new UserData();
            $max=$userData2->getMaxId($start);
            dump(date_format($start, "Y-m-d H:00:00").'==>'.$max);
            $id = 1;
            //$max=20;

            //while($id<=$max){
                dump('deal  '.$id);
                // $datafac->createReport(
                //     1,
                // //$id,
                // date_format($start,"Y-m-d H:00:00"),
                // date_format($end,"Y-m-d H:00:00"),
                // 'CYC01'
                // );
                // $datafac->run();

                //  $info=$datafac->createReport(
                //      1,
                // // //$id,
                //  date_format($start,"Y-m-d H:00:00"),
                //  date_format($end,"Y-m-d H:00:00"),
                //  'CYC01'
                //  );
                // //dump($info);
                // $datafac->run();
                // $item=$datafac->getById(1,$info['start']);
                // //dump($item);
                // $tmp=$coinAccountData->getInfo(1);
                // //dump($tmp);
                // foreach($tmp as $value)
                // {
                //     $reportUserCoinItemData->createReport($item->report_no,$value->usercoin_cointype);
                // }
                //$datafac->createReport('RUC2017062820524534148','KKC-BJ0001');
                $id ++;
            // }
            /* for($id=1;$id<$max+;$id++)
            {
                /*$datafac->createReport(
                $id,
                date_format($start,"2017-4-6 0:00:00"),
                date_format($end,"2017-6-21 0:00:00"),
                //"2017-4-6 0:00:00",
                //"2017-6-21 0:00:00",
                "CYC01");*/
               // $datafac->createReport(
             //   $id,
              //  date_format($start,"Y-m-d H:00:00"),
               // date_format($end,"Y-m-d H:00:00"),
                //"2017-6-21 0:00:00",
              //  //"2017-6-22 0:00:00",
              //  "CYC01");       
            // }
            //   $pageIndex ++;
            //   $result = $userFac->query([],$pageSize,$pageIndex);   
            //}
      
            date_add($start, date_interval_create_from_date_string("1 day"));
        
            $i++;

        }
        
        $this->assertTrue(true);
    }
}
