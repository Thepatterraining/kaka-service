<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\User\UserData;

class IdTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $fac = new UserData();
        $result =  $fac->tongDunApi('石德晓', '37132319900217217X');
        dump($result);
        $this->assertTrue(true);
    }
}
