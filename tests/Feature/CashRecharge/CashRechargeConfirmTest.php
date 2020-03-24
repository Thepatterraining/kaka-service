<?php

namespace Tests\Feature\CashRecharge;

use Tests\TestCase;
use App\Data\Cash\RechargeData;

class CashRechargeConfirmTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCashRecharge()
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

        //充值
        dump('充值审核：');
        $rechargeData = new RechargeData;
        $where['cash_recharge_status'] = RechargeData::STATUS_APPLY;
        $recharge = $rechargeData->find($where);
        
        if (!empty($recharge)) {
            $rechargeNo = $recharge->cash_recharge_no;
            // $rechargeNo = 'CR2017112111342872656';
            $confirm = rand(0, 1);
            dump($confirm);
            $response = $this->rachargeConfirm($token, $rechargeNo, $confirm);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        

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

    protected function rachargeConfirm($token, $rechargeNo, $confirm)
    {
        $response = $this->json(
            'POST', '/api/cash/rechargconfirm', [
            "accessToken"=>$token,
            'no'=>$rechargeNo,
            'confirm'=>$confirm,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
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
}
