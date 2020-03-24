<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetCodeInfoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCodeInfo()
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

        //获取邀请码信息
        dump('获取邀请码信息：');
        $response = $this->getcodeinfo($token);
        dump($response);
        $arr=array(1,2,3,4);
        $arr1=8;
        foreach($arr as $value){
            var_dump($arr1);
            $arr1++;
        }
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }
    protected function getcodeinfo($token)
    {
        $response = $this->json(
            'POST', '/api/user/getcodeinfo', [
            "accessToken"=>$token,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
