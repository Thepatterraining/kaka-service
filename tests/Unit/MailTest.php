<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Tests\Unit\TestModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Mail\Report;

class MailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
       

        $items= Route::getRoutes();
     
       
        foreach($items->get() as $controller){
            if($controller->uri == 'api/admin/getdic') {
                dump('OK');
                $c =$controller->controller; 
            }
        } 
        $this->assertTrue(true);
    }
}
