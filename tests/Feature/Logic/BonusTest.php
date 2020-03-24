<?php

namespace Tests\Feature\Logic;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use  App\Data\Bonus\ProjBonusData;

class BonusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {


        $bonusData = new ProjBonusData();
            $no = $bonusData->createBonus('', '2017-7-1', 5800, 1450, 0.01, '2017-4-1', '2017-6-30', 'KKC-BJ0001');
     

        $this->assertTrue(true);
    }
}
