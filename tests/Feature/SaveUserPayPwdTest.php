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

class SaveUserPayPwdTest extends TestCase
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
        // dump($response);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        //开始登陆
        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->login($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        $phone = 13263463442;
        $paypwd = 'Pa88word123';
        $verify = 'KaKamfPwd8080';
        $response = $this->saveUserPwd($phone, $token, $paypwd, $verify);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(801001, $response['code']);

        $phone = 13263463442;
        $paypwd = '123qweA';
        $verify = 'KaKamfPwd8080';
        $response = $this->saveUserPwd($phone, $token, $paypwd, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        
    }

    protected function saveUserPwd($phone, $token, $paypwd, $verify)
    {
        $response = $this->json(
            'POST', '/api/auth/savepaypwd', array(
            "accessToken"=>$token,
            "phone"=>$phone,
            "paypwd"=>$paypwd,
            "verify"=>$verify,
            )
        );
        $response->assertStatus(200);
        return $response->json();
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
