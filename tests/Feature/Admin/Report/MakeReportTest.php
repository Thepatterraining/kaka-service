<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class MakeReportTest extends TestCase
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
        // $data = new \App\Data\Report\ReportUserrbSubDayData;
        $url='v2/admin/report/day/userrb';
        $queryfilter=array();
        $map='{
            "编号": "no",
            "报表名称": "name",
            "用户": "user",
            "上结邀请数": "initInv",
            "邀请增长数": "ascInv",
            "邀请总数": "currentInv",
            "上期消费用户数": "rbInitInv",
            "消费用户增长": "rbAscInv",
            "消费用户总数": "rbCurrentInv",
            "上期充值": "rbRechargeInit",
            "本期增加": "ascBuy",
            "本期累计": "resultBuy",
            "上期购买": "initBuy",
            "充值增长": "rbRechargeAsc",
            "充值累计": "rbRechargeResult",
            "充值返佣是否支付": "rbRechargeIspay",
            "充值返佣发起": "rbRechargePayuser",
            "充值返佣发起时间": "rbRechargePaytime",
            "充值返佣审核": "rbRechargeChkuser",
            "充值返佣审核时间": "rbRechargeChktime",
            "上期佣金": "rbBuyInit",
            "佣金增长": "rbBuyAsc",
            "佣金累计": "rbBuyResult",
            "消费佣金是否支付": "rbBuyIspay",
            "消费佣金支付发起人": "rbBuyPayuser",
            "消费佣金支付发起时间": "rbBuyPaytime",
            "消费佣金审核人": "rbBuyChkuser",
            "消费佣金审核时间": "rbBuyChktime",
            "开始时间": "start",
            "结束时间": "end",
            "充值计算起始时间": "rbRechargeStart",
            "购买计算起始时间": "rbBuyStart",
            "是否充许操作": "enableOperation"
        }';
        $map=json_decode($map, true);
        $response = $this->confirm($token, $url, $map, $queryfilter);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        
    }

    protected function confirm($token, $url, $map, $queryfilter)
    {
        $response = $this->json(
            'POST', '/api/v2/admin/report/makereport', array(
            "accessToken"=>$token,
            "url"=>$url,
            "map"=>$map,
            "queryfilter"=>$queryfilter
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