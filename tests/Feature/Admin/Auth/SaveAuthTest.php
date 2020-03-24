<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class SaveAuthItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetTrendList()
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
        // $user = '13263463444';
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

        //修改权限s
        dump('修改权限');
        $authData = new \App\Data\Auth\ItemData;
        $model = $authData->newitem();
        $authid = $model->pluck('id')->first();
        dump($authid);
        // $authid = 2;
        $data['no'] = '001';
        $data['name'] = '666';
        $data['url'] = '/api/admin/auth/createauth';
        $data['type'] = 'AU05';
        $data['notes'] = '备注1';
        $response = $this->getList($token, $authid, $data);
        dump($response);
        if (count($response) == 4) {
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

    protected function getList($token, $authid, $data)
    {
        $response = $this->json(
            'POST', '/api/admin/auth/saveauth', array(
            "accessToken"=>$token,
            "authid"=>$authid,
            "data"=>$data
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

}
