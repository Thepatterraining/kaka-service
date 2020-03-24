<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class CheckCode extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCheckCode()
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

        //判断验证码
        dump('判断验证码');
        $code = '123456';
        $response = $this->CheckCode($token, $code);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //判断验证码
        dump('判断验证码');
        $code = '12345678';
        $response = $this->CheckCode($token, $code);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }
    protected function CheckCode($token, $code)
    {
        $response = $this->json(
            'POST', '/api/auth/checkregcode', [
            "accessToken"=>$token,
            "code"=>$code,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
