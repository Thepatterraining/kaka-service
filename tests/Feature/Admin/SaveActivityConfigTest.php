<?php

namespace Tests\Feature;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegCofigData;
use App\Data\User\UserData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class SaveActivityConfigTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testSaveActivityConfig()
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
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));

        dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //查询活动配置列表
        $userType = 'UT01';
        $data = [];
        $response = $this->saveInfo($token, $userType, $data);
        dump($response);
        if (count($response) == 4) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        } else {
            $this->assertCount(3, $response);
            $this->assertEquals(801010, $response['code']);
        }
        

        $userType = 'UT01';
        $data['usertype'] = 'UT01';
        $data['code'] = '12345';
        $response = $this->saveInfo($token, $userType, $data);
        dump($response);
        if (count($response) == 4) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        } else {
            $this->assertCount(3, $response);
            $this->assertEquals(801010, $response['code']);
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

    protected function saveInfo($token, $userType, $data)
    {
        $response = $this->json(
            'POST', '/api/admin/saveactivityconfig', [
            "accessToken"=>$token,
            "userType"=>$userType,
            "data"=>$data
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function login($user, $token, $pwd, $type = false)
    {
        //用户登陆
        //        $user  = 'kk970645';
        $response = $this->json(
            'POST', '/api/auth/login', array(
            "accessToken"=>$token,
            "userid"=>$user,
            "pwd"=>$pwd

            )
        );
        $response->assertStatus(200);

        return $response->json();
        $name = $response->json();
        dump('登陆成功');

        //        if ($type == 1) {
            dump($response->json());
            return $response->json()['data']['id'];
        //        }

        if ($type == false) {
            //            $user = $this->getUser($token);
            //            return $this->login($user,$token,1);
        }
    }

    protected function getUser($token)
    {
        $pageIndex = rand(1, 10);
        $pageSize = rand(10, 12);
        $index = rand(1, 9);
        $response = $this->json(
            'POST', '/api/admin/getuserlist', [
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize,
            ]
        );
        $response
            ->assertStatus(200)
            ->assertJson(
                [
                'code' => 0,
                ]
            );

        $user = $response->json()['data']['items'][$index]['user'];
        return $user;
    }
}
