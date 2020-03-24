<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class ConfirmRebateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCurves()
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

        //发起分红
        dump('审核分红');
        $data = new \App\Data\Report\ReportUserrbSubDayData;
        $where['report_enable_operation'] = 1;
        $info = $data->find($where);
        if (!empty($info)) {
            $reportNo = $info->report_no;
            // $bonusNo = 'phpunitRightNo';
            $confirm = 1 == 1 ? true : false;
            $response = $this->confirm($token, $reportNo, $confirm);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        
    }

    protected function confirm($token, $reportNo, $confirm)
    {
        $response = $this->json(
            'POST', '/api/v2/admin/report/confirmrebate', array(
            "accessToken"=>$token,
            "reportNo"=>$reportNo,
            "confirm"=>$confirm,
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
