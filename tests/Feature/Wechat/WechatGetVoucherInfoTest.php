<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class WechatGetVoucherInfoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetVoucherInfo()
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

        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->mobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //查询用户代金券信息
        dump('查询用户代金券信息：');
        $no = 'VCN2017031915460142480';
        $response = $this->getVoucherInfo($token, $no);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);


        //查询用户代金券信息
        dump('查询用户代金券信息：');
        $no = 'werw';
        $response = $this->getVoucherInfo($token, $no);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(880001, $response['code']);
    }

    protected function mobileLogin($phone, $token, $verify)
    {
        $response = $this->json(
            'POST', '/api/auth/mobilelogin', array(
            "accessToken"=>$token,
            "phone"=>$phone,
            "verify"=>$verify
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getVoucherInfo($token, $no)
    {
        $response = $this->json(
            'POST', '/api/wechat/getvoucherinfo', [
            "accessToken"=>$token,
            'no'=>$no,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
