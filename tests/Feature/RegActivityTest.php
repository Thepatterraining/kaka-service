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

class RegActivityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testRegActivity()
    {
        //        dump('测试开始');
        //        dump("Require Token:");
        //        $response = $this->json('POST', '/api/auth/token/require',array());
        //        $response->assertStatus(200);
        //        $this->assertEquals(4,count($response->json()));
        //        $this->assertEquals(2,count($response->json()["data"]));
        //        $this->assertEquals(0,$response->json()['code']);
        //        $token = $response->json()["data"]["accessToken"];
        //
        //        dump($token);
        //
        //        //登陆
        //        dump('正常登陆');
        //        $user = '13263463442';
        //        $pwd = '123qwe';
        //        $user = $this->login($user,$token,$pwd);
        //        $this->assertCount(4,$user);
        //        $userid = $user['data']['id'];
        //        $this->assertTrue(is_numeric($userid));
        //
        //
        //        $datafac = new UserData();
        //
        //        $infoData = new InfoData();
        //        $invitationData = new InvitationCodeData();
        //        $code = 1234;
        //        $userType = $datafac->getCode($code);
        //        $codeRes = '';
        //        if ($userType != null) {
        //            //查询邀请注册设置表，拿到活动编号
        //            $codeRes = 'USER';
        //        } else {
        //            //查邀请码是否为活动邀请码
        //            $activityInfo = $infoData->getCodeInfo($code);
        //            if ($activityInfo != null) {
        //                $codeRes = 'ACTIVITY';
        //            } else {
        //                //查邀请码是否为活动邀请码 activity_invitationcode
        //                $where['invite_code'] = $code;
        //                $model = $invitationData->newitem();
        //                $invitation = $model->where($where)->first();
        //                if ($invitation != null) {
        //                    $codeRes = 'INVITATION';
        //                }
        //            }
        //        }
        //        $this->assertEmpty($codeRes);
        //
        //        $code = 123456789;
        //        $userType = $datafac->getCode($code);
        //        $codeRes = '';
        //        if ($userType != null) {
        //            //查询邀请注册设置表，拿到活动编号
        //            $codeRes = 'USER';
        //        } else {
        //            //查邀请码是否为活动邀请码
        //            $activityInfo = $infoData->getCodeInfo($code);
        //            if ($activityInfo != null) {
        //                $codeRes = 'ACTIVITY';
        //            } else {
        //                //查邀请码是否为活动邀请码 activity_invitationcode
        //                $where['invite_code'] = $code;
        //                $model = $invitationData->newitem();
        //                $invitation = $model->where($where)->first();
        //                if ($invitation != null) {
        //                    $codeRes = 'INVITATION';
        //                }
        //            }
        //        }
        //
        //        dump($codeRes);
        //        $this->assertEquals('USER',$codeRes);
        //        $regcofigData = new RegCofigData();
        //        $regcofigInfo = $regcofigData->getInfo($userType);
        //        if ($regcofigInfo == null) {
        //            dd(1);
        //        }
        //        $activityNo = $regcofigInfo->invite_activitycode;
        //
        //        $infoData->addUserActivity($activityNo,$userid);
        //
        //        //如果是活动
        //        $codeRes = 'ACTIVITY';
        //        $code = '345fg76k';
        //        $activityInfo = $infoData->getCodeInfo($code);
        //        if ($activityInfo == null) {
        //            dd(1);
        //        }
        //        $activityNo = $activityInfo->activity_no;
        //        dump($codeRes);
        //        $this->assertEquals('ACTIVITY',$codeRes);
        //        $infoData->addUserActivity($activityNo,$userid);
        //
        //        $codeRes = 'INVITATION';
        //        $code = 87654321;
        //        $invitationInfo = $invitationData->getByNo($code);
        //        if ($invitationInfo == null) {
        //            dd(1);
        //        }
        //        $activityNo = $invitationInfo->invite_activity;
        //        dump($codeRes);
        //        $this->assertEquals('INVITATION',$codeRes);
        //        $infoData->addUserActivity($activityNo,$userid);
        //
        //        $response = $invitationData->saveCount($code);
        //        $this->assertTrue($response);
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
