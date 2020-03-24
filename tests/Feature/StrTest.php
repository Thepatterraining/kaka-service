<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StrTest extends TestCase
{



    public function testStr()
    {

        //        $a = "12121212";
        //       // $b = "{${substr($a,1)}}";
        //        //dump($b);
        //
        //
        //        $item= (object) array('cash_recharge_bankid' => '1267652345324234234324', 'property' => 'value');
        //
        //
        //        $str = '充值成功,${strlen($item->cash_recharge_bankid)} 汇款已经收到';
        //        $str = '充值成功,${strlen($item->cash_recharge_bankid)} 汇款已经收到';
        //        $str = '充值成功,${strlen($item->cash_recharge_bankid)} 汇款已经收到';
        //
        //        $strd = "return \"".$str."\";";
        //
        //        $strc = eval($strd);
        //        dump($strc);
        //        return true;
        // 	dump('is int 1');
        //     dump(is_int(1));
        //     dump(is_int(14));
        // 	dump('is int str 111');
        //     dump(is_int("111"));
        //     dump(is_numeric("14"));

           
        //    $this->assertTrue(TRUE);
        //         return true;
        // dump(bccomp('2334.247',1182.87,3));
        dump(md5("pwd2123456"));
    }
    /**
     * A basic test example.
     *
     * @depends testStr
     * @return  void
     */
    public function testExample()
    {

       
        $this->assertTrue(true);
     
        return true;
    }
}
