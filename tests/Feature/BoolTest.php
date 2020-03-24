<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Common\BoolExpression\IBoolExpression;
use App\Common\BoolExpression\BoolExpFactory;
use App\Data\Common\LeftExpFactory;
use App\Data\Common\RightExpFactory;

class BoolTest extends TestCase implements IBoolExpression
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBool()
    {
        if($this->GetResult()) {
            dump('true');
        } 
        else
        {
            dump('false');
        }
    }
    public function GetResult()
    {
        $userId=1;
        $exp="reg_time>='2017-4-6'&&cash_availble<=1";
        $leftFactory=new LeftExpFactory($userId);
        $rightFactory=new RightExpFactory();
        $boolExpreFactory=new BoolExpFactory($leftFactory, $rightFactory, $exp);
        return $boolExpreFactory->handle();
    }
}
