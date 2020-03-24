<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class ConfirmUserActivityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testConfirmUserActivity()
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

        //给用户添加代金券
        dump('审核成功：');
        $confirm = true;
        $no = 11111;
        $response = $this->confirm($token, $no, $confirm);
        $this->assertCount(3, $response);
        $this->assertEquals(880001, $response['code']);


        //给用户添加代金券
        dump('查看用户参加活动列表：');
        $pageIndex = 1;
        $pageSize = 10;
        $response = $this->getUserActivity($token, $pageIndex, $pageSize);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        if (count($response['data']['items']) > 0) {
            $no = $response['data']['items'][0]['no'];

            //给用户添加代金券
            dump('审核成功：');
            $confirm = true;
            $response = $this->confirm($token, $no, $confirm);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
            dump($response);

            //给用户添加代金券
            dump('审核成功：');
            $confirm = false;
            $response = $this->confirm($token, $no, $confirm);
            $this->assertCount(3, $response);
            $this->assertEquals(802006, $response['code']);
            dump($response);

            //给用户添加代金券
            dump('查看用户参加活动列表：');
            $pageIndex = 1;
            $pageSize = 10;
            $response = $this->getUserActivity($token, $pageIndex, $pageSize);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
            $no = 1;
            foreach ($response['data']['items'] as $val) {
                if ($val['status']['no'] == 'ASS00') {
                    $no = $val['no'];
                }
            }

            //给用户添加代金券
            dump('审核成功：');
            $confirm = false;
            $response = $this->confirm($token, $no, $confirm);
            if (count($response) == 4) {
                $this->assertCount(4, $response);
                $this->assertEquals(0, $response['code']);
            } else {
                $this->assertCount(3, $response);
                $this->assertEquals(802006, $response['code']);
            }
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

    protected function confirm($token, $no, $confirm)
    {
        $response = $this->json(
            'POST', '/api/admin/activityconfirm', [
            "accessToken"=>$token,
            'no'=>$no,
            'confirm'=>$confirm,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserActivity($token, $pageIndex, $pageSize)
    {
        $response = $this->json(
            'POST', '/api/admin/getuseractivitylist', [
            "accessToken"=>$token,
            'pageIndex'=>$pageIndex,
            'pageSize'=>$pageSize,
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
