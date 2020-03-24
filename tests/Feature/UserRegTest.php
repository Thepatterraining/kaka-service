<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class UserRegTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testUserReg()
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

        //h5用户注册
        // dump('h5用户注册');
        // $pwd = "123qwe";
        // $imgVerify = '1231251342';
        // $code = 'KaKamfv5';
        // $data['mobile'] = '18211149923';
        // $data['data'] = $data;
        // $response = $this->reg($token,$pwd,$imgVerify,$data,$code);
        // dump($response);
        // if (count($response) === 3) {
        //     $this->assertCount(3,$response);
        //     $this->assertEquals(801018,$response['code']);
        // } else {
        //     $this->assertCount(4,$response);
        //     $this->assertEquals(0,$response['code']);
        // }


        // //微信用户注册
        // dump('微信用户注册：');
        // $openid = 5;
        // $appid = 'wx131f45fbf860026f';
        // $pwd = "123qwe";
        // $paypwd = '1234qweA';
        // $code = 'KaKamfv5';
        // $data['mobile'] = '18211149914';
        // $data['data'] = $data;
        // $response = $this->appReg2($token,$openid,$appid,$pwd,$paypwd,$data,$code);
        // dump($response);
        // if (count($response) === 3) {
        //     $this->assertCount(3,$response);
        //     $this->assertEquals(880001,$response['code']);
        // } else {
        //     $this->assertCount(4,$response);
        //     $this->assertEquals(0,$response['code']);
        // }
    }

    protected function reg($token, $pwd, $imgVerify, $data = [], $code)
    {
        $response = $this->json(
            'POST', '/api/token/user/reg', [
            "accessToken"=>$token,
            'pwd'=>$pwd,
            'imgVerify'=>$imgVerify,
            'code'=>$code,
            'data'=>$data,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
