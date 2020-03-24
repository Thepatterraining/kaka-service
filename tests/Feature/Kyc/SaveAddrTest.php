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

class SaveAddrTest extends TestCase
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

        //kyc验证状态修改
        dump('kyc验证状态修改');
        $coinAddress = '13263463442';
        $count = '1692';
        $response = $this->SaveAddr($coinAddress, $token, $count);
        dump($response);
        if (count($response) == 4) {
            $this->assertEquals(0, $response['code']);
        }
        
    }

    protected function SaveAddr($coinAddress, $token, $count)
    {
        $response = $this->json(
            'POST', '/api/token/auth/saveCoinAddr', array(
            "accessToken"=>$token,
            "address"=>$coinAddress,
            "count" => $count,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
