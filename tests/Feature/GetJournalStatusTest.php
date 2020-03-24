<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\User\CashJournalData;
use App\Data\User\UserData;

class GetJournalStatusTest extends TestCase
{
    public function test()
    {
        //  $date=date("Y-m-d");
        // // $date=date("2017-7-18");
        // $start=date_create($date);
        // $end=date_create($date);
        // date_add($start, date_interval_create_from_date_string("-1 days"));

        // $cashJournalFac=new CashJournalData();
        // $userFac=new UserData();

        // $pageSize = 100;
        // $pageIndex = 1;
        // $filter=[
        //     "created_at"=>['<=',$end]
        // ];
        // $result = $userFac->query($filter,$pageSize,$pageIndex);
        // // dump($result["totalSize"]);
        // // return $result;
        // while($pageIndex<=($result["pageCount"])){  
        //     foreach($result["items"] as $resultitem){
        //         // $sum=$cashJournalFac->newItem()->orderBy('id','desc')
        //         //     ->orderBy('usercash_journal_datetime','desc')->where('usercash_journal_datetime','<=',$end)
        //         //                                     ->where('usercash_journal_userid',$resultitem->id)->first();
        //          $sum=$cashJournalFac->newItem()->orderBy('id','desc')->where('usercash_journal_datetime','<=',$end)
        //                                         ->where('usercash_journal_userid',$resultitem->id)->first();

                                                
        //         if(empty($sum))
        //         {  
        //             $sumCount=0;
        //         }
        //         else
        //         {
        //             $sumCount=$sum->usercash_result_cash;
        //         }
        //         dump($resultitem->id."  ".$sumCount);
        //         if($sumCount<0)
        //         {
        //             exit ;
        //         }
        //         // $res['sumCount']+=$sumCount;
        //     }
        //     $pageIndex ++;
        //     $result = $userFac->query($filter,$pageSize,$pageIndex);   
        // }
        // return true;
    }
}      