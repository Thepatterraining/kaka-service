<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Trade\TranactionSellData;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Product\InfoData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
class VoucherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
          
        $session = resolve('App\Http\Utils\Session');
          $productData = new InfoData();
        $session->userid = 185;
        $data = new RegVoucherData();
        $sellno = "TS2017052107345686483";
        $count = 33;
        $res = $data->getUserProductVoucher($count, $sellno);
         $sellNo = $productData->getSellNo("PRO2017052107345697433");
        //查询卖单
        $sellData = new TranactionSellData();
        $sellRes = $sellData->isVoucher($sellNo);
        //不可用
        if ($sellRes === false) {
            dump(false);
        }

         $adapter = new VoucherInfoAdapter();
        $res = $adapter->getDataContract($res);
        $voucherNo = array_get($res, 'no');
      
        $voucherStorageData = new VoucherStorageData();
        $voucherStorageAdapter = new VoucherStorageAdapter();
        $voucherStorage = $voucherStorageData->getStorage($voucherNo);
        $voucherStorage = $voucherStorageAdapter->getDataContract($voucherStorage);
        $res['voucherStorageNo'] = $voucherStorage['no'];



        dump($res);
        $this->assertTrue(true);
    }
}
