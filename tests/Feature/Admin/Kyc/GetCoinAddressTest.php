<?php

namespace Tests\Feature\Kyc;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\FinanceBankData;
use App\Data\User\BankAccountData;
use App\Http\Adapter\Cash\FinanceBankAdapter;
use App\Http\Adapter\User\UserBankCardAdapter;

class GetCoinAddressTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetAdminBankList()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/adminrequire', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];

        dump($token);

         dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //开始查询列表
        dump('查询列表');
        $pageSize = 10;
        $pageIndex = 1;
        $response = $this->getList($token, $pageSize, $pageIndex);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function adminLogin($userid, $token, $pwd)
    {
        $response = $this->json(
            'POST', '/api/admin/login', array(
            "accessToken"=>$token,
            "userid"=>$userid,
            "pwd"=>$pwd
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getList($token, $pageSize, $pageIndex)
    {
        $response = $this->json(
            'POST', '/api/v2/admin/kyc/getcoinaddress', array(
            "accessToken"=>$token,
            "pageSize"=>$pageSize,
            "pageIndex"=>$pageIndex,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
