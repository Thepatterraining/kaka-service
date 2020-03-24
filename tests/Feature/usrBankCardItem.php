<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\HttpLogic\BankLogic;

class usrBankCardItem extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {


        $logic = new BankLogic();
        $info = $logic->getUserCardInfo("6225881010728375");
        dump($info);
        $this->assertTrue(true);
    }
}
