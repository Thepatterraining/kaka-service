<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use Tests\Unit\TestModel;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\Formater;
use App\Data\API\Payment\OpenSwiftJspay;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $sstr = "CR2017052616545131897";
        $str2 = "PREO2017052716370401333";

        //    for($i = 0.01;$i<10;$i=$i+0.01){
        //        dump($i . " " .Formater::ceil($i));
        //    }
       
        //    $docno = "PREO2017060618530404040";


        //    $arry = [
        //        "status"=>"0",
        //        "result_code"=>"0",
        //        "pay_result"=>"0",
        //        "out_trade_no"=>$docno,
        //        "attach"=>"1"

        //    ];
       
        //    $pay = new OpenSwiftJspay();

        //    $str = $pay->addChk($arry);
        //    dd($str);
        //    dump(Formater::ceil(9.731));

     
              $this->assertTrue(true);
    }
    private function getFee($cash)
    {

        $toCal = intval($cash * 100);
        $cal2 = $toCal/100;
        dump("step1 ".$cal2*100);
        dump("step2 ".$cal2);
        dump("step3 ". ceil(intval($cal2*100)));


        return ceil($cal2*100)/100;
    }

    private function round_out($value, $places = 0)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);
        return ($value >= 0 ? ceil($value * $mult):floor($value * $mult)) / $mult;
    }


    function get_currency($value, $places)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);
        $tmpValue = floor($value*$mult);
        $x = floor($value*$mult*10)-$tmpValue*10;
        if ($x > 0) {
            $value = $tmpValue + 1;
        } else {
            $value = $tmpValue;
        }
        //$value = $x > 0 ? $tmpValue:$tmpValue +1;
        return $value/100;
    }
}
