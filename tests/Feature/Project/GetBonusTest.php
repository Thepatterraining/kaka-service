<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetBonusTest extends TestCase
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

        //开始新建产品
        dump('开始查询项目分红列表');
        $coinType = "KKC-BJ0006";
        $pageSize = 10;
        $pageIndex = 1;
        $response = $this->getList($token, $coinType, $pageSize, $pageIndex);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function getList($token, $coinType, $pageSize, $pageIndex)
    {
        $response = $this->json(
            'POST', '/api/token/project/getbonus', array(
            "accessToken"=>$token,
            "coinType"=>$coinType,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
