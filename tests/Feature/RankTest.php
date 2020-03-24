<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Redis;
use App\Data\Rank\OrderList;

class RankTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {


        $test = new OrderList("KK-0001");

                $test->AddSell(100, 1);
            $test->AddSell(200, 5);
               $test->AddOrder(300, 8);
               $test->AddSell(100, 3);

        
                   $result =$test->GetSell(20);
    
            //   
            dump($result);
        $this->assertTrue(true);
    }
}
