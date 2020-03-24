<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetCoordinatesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCurves()
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

        //开始查询项目坐标
        dump('开始查询项目坐标');
        $productData = new \App\Data\Product\InfoData;
        $info = $productData->get(1);
        // $no = $info->product_no;
        $no = 'PRO2017090521142908509';
        $response = $this->getList($token, $no);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function getList($token, $no)
    {
        $response = $this->json(
            'POST', '/api/token/project/getcoordinates', array(
            "accessToken"=>$token,
            "no"=>$no,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
