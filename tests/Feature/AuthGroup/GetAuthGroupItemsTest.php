<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetAuthGroupItemsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCreatePay()
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

        //登陆
        // dump('正常登陆');
        // $user = '13263463442';
        // $pwd = '123qwe';
        // $user = $this->login($user,$token,$pwd);
        // dump($user);
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));
        // dump('用户id:'.$userid);

        dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        $authData = new \App\Data\Auth\AuthGroupData;
        $model = $authData->newitem();
        $groupid = $model->pluck('id')->first();
        dump($groupid);
        // $groupid = 2;
        if ($groupid > 0) {
            $response = $this->create($token, $groupid);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        
        
    }

    protected function create($token, $groupid)
    {
        $response = $this->json(
            'POST', '/api/admin/auth/getauthgroupitems', array(
            "accessToken"=>$token,
            "groupid"=>$groupid,
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
