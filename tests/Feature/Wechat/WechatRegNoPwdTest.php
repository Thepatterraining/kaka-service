<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class WechatRegNoPwdTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testWechatAppReg()
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

        //微信用户注册
        dump('微信用户注册：');
        $openid = 5;
        $appid = 'wx131f45fbf860026f';
        $paypwd = '1234qweA';
        $code = '';
        $data['mobile'] = '18211149322';
        $data['data'] = $data;
        $pwd = '';
        $response = $this->appReg($token, $openid, $appid, $pwd, $paypwd, $data, $code);
        dump($response);
        if (count($response) == 3) {
            $this->assertCount(3, $response);
            $this->assertEquals(880001, $response['code']);
        } else {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }


        //微信用户注册
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

    protected function appReg($token, $openid, $appid, $pwd, $paypwd, $data = [], $code)
    {
        $response = $this->json(
            'POST', '/api/wechat/regnopwd', [
            "accessToken"=>$token,
            'verify'=>'KaKamfPwd8080',
            // 'code'=>$code,
            // 'paypwd'=>$paypwd,
            'data'=>$data,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
