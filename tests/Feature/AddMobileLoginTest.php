<?php
namespace Tests\Feature;

use App\Data\Sys\ErrorData;
use App\Data\Sys\LoginLogData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class AddMobileLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddMobileLogin()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json(
            'POST', '/api/auth/token/require', [
            'appid' => 'F3452E02-AE64-A825-8C29-DFE5B2EA9C57',
            'appSecrect' => '9F7huqSentmOWddT',
            ]
        );
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        // $tradeFac = new \App\Data\TradeIndexFactory;
        // $res = $tradeFac->addTrade('KKC-BJ0001',2000);
        // dump($res);
        // die;
        //开始登陆
        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->login($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        $response = $this->json(
            'POST', '/api/token/auth/getuser', [
            'accessToken'=>$token,
            ]
        );
        dump($response->json());

        // $x = bcsub(0.00010000, 0.00000000, 9);
        // dump($x);
        // if (bccomp($x, 0.0001, 9) === 1) {
        //     dump(1);
        // }
        // dump(0);

        //开始登陆
        // dump('手机号登陆');
        // $phone = '13263463450';
        // $verify = 123456;
        // $response = $this->login($phone,$token,$verify);
        // dump($response);
        // $this->assertCount(3,$response);
        // $this->assertEquals(801001,$response['code']);
    }

    protected function login($phone, $token, $verify)
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
}
