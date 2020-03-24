<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetItemFormulaTest extends TestCase
{
    public function testGetItemFormula()
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
        $no = 'PRO2017051000220333526';
        $response = $this->getItemFormula($token, $no);
        dump($response);
        if (count($response) == 4) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        } else {
            $this->assertCount(3, $response);
            $this->assertEquals(802006, $response['code']);
        }
    }

    protected function getItemFormula($token, $no)
    {
        $response = $this->json(
            'POST', '/api/item/getfromula', [
            "accessToken"=>$token,
            "no"=>$no,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
