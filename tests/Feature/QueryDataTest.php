<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\Admin\ThirdPayment\IncomeDocList;
use App\Http\Utils\Session;

class QueryDataTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $controller = new IncomeDocList(new Session());
        // $controller ->getJobData([]);
        $this->assertTrue(true);
    }
}
