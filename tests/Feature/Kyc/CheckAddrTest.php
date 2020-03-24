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

class CheckAddrTest extends TestCase
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
        $response = $this->json('POST', '/api/auth/token/require', [
            'appid' => 'F3452E02-AE64-A825-8C29-DFE5B2EA9C57',
            'appSecrect' => '9F7huqSentmOWddT',
        ]);
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        //kyc验证
        dump('kyc验证 邮箱不对');
        $data['coinAddress'] = '13263463442';
        $data['mobile'] = '13263463442';
        $data['userIdno'] = '13263463442';
        $data['userName'] = '13263463442';
        $data['userEmail'] = '13263463442';
        $verify = 'KaKamfPwd8080';
        $emailVerify = 'email';
        $response = $this->checkAddr($data, $token, $verify, $emailVerify);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(880001, $response['code']);

        //开始登陆
        dump('kyc验证');
        $data['coinAddress'] = '13263463442';
        $data['mobile'] = '13263463442';
        $data['userIdno'] = '13263463442';
        $data['userName'] = '13263463442';
        $data['userEmail'] = 'kaka@kaka.com';
        $verify = 'KaKamfPwd8080';
        $emailVerify = 'email';
        $response = $this->checkAddr($data, $token, $verify, $emailVerify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function checkAddr($data, $token, $verify, $emailVerify)
    {
        $data['data'] = $data;
        $response = $this->json(
            'POST', '/api/token/auth/checkCoinAddr', array(
            "accessToken"=>$token,
            "data"=>$data,
            "verify"=>$verify,
            "emailVerify" => $emailVerify,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
