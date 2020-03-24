<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\WithdrawalData;

class CashWithdrawalConfirmTest extends TestCase
{

    private $paypwd = '123qweA';

    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCashWithdrawal()
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

        $bankid = 6214830121885395;
        dump('用户银行卡'.$bankid);

        dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //提现
        dump('提现审核：');
        $withData = new WithdrawalData;
        $where['cash_withdrawal_status'] = WithdrawalData::APPLY_STATUS;
        $with = $withData->find($where);
        if (!empty($with)) {
            $withNo = $with->cash_withdrawal_no;
            $confirm = 0;//rand(0, 1);
            $withRes = $this->withConfirm($token, $withNo, $confirm);
            dump($withRes);
            if ($withRes['code'] == 0) {
                $this->assertCount(4, $withRes);
            }
        }
        
    }

    protected function withConfirm($token, $withNo, $confirm)
    {
        $response = $this->json(
            'POST', '/api/cash/withdrawalconfirm', array(
            "accessToken"=>$token,
            "confirm"=>$confirm,
            "no"=>$withNo,
            "paypwd"=>$this->paypwd,
            )
        );
        $response->assertStatus(200);
        return $response->json();
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
}
