<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetItemInvestTest extends TestCase
{
    public function testGetItemInf()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        //查看项目详细信息
        dump('查看项目详细信息');
        $coinType = 'KKC-BJ0001';
        $productData = new \App\Data\Product\InfoData;
        $where['product_status'] = \App\Data\Product\InfoData::$PRODUCT_STATUS_ON_SALE;
        $product = $productData->find($where);
        if (!empty($product)) {
            $no = $product->product_no;
            // $no = 'PRO2017042719481748801';
            // $response = $this->getItemInvest($token, $coinType, $no);
            // dump($response);
            // if (count($response) == 4) {
            //     $this->assertCount(4, $response);
            //     $this->assertEquals(0, $response['code']);
            // } else {
            //     $this->assertCount(3, $response);
            //     $this->assertEquals(802006, $response['code']);
            // }
        }
        
    }

    protected function getItemInvest($token, $coinType, $no)
    {
        $response = $this->json(
            'POST', '/api/item/getinvestinfo', [
            "accessToken"=>$token,
            'coinType'=>$coinType,
            "no"=>$no,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
