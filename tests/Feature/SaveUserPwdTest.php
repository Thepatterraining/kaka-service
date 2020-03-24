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

class SaveUserPwdTest extends TestCase
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
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        // dump($response);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        $phone = 13263463442;
        $pwd = '123qwe';
        $verify = 'KaKamfPwd8080';
        $response = $this->saveUserPwd($phone, $token, $pwd, $verify);
        dump($response);
        
    }

    protected function saveUserPwd($phone, $token, $pwd, $verify)
    {
        $response = $this->json(
            'POST', '/api/auth/savepwd', array(
            "accessToken"=>$token,
            "phone"=>$phone,
            "pwd"=>$pwd,
            "verify"=>$verify,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
