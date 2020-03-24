<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\DocNoMaker;

class RegExTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //        dump('test Reg');
        //        $regMath = "/([a-z-A-Z])+([0-9]){19}/";
        //
        //
        //        dump(preg_match($regMath,"CCJ2017031515273068625"));//1
        //
        //        dump(preg_match($regMath,"C2017031515273068625"));//1
        //
        //        dump(preg_match($regMath,"2017031515273068625"));//0
        //
        //        dump(preg_match($regMath,"222CCJ201703151527306862523222"));//1
        //
        //        dump(preg_match($regMath,"CCJ2017031515273065"));//0
        //
        //        dump(preg_match($regMath,"CCJ2017031515273068625"));//1
        //
        //        dump(preg_match($regMath,"CCJ201703151527"));
        //
        //
        //        $maker = new DocNoMaker();
        //
        //        for($i = 0;$i<1000;$i++){
        //            $docNo= DocNoMaker::Generate("KK");
        //            $result=preg_match($regMath,$docNo);
        //        dump("{$docNo} {$result}")  ;
        //
        //        }
        //
        //        $this->assertTrue(true);
    }
}
