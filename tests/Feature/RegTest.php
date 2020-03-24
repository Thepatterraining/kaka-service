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

class RegTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testReg()
    {
               dump('测试开始');
               dump("Require Token:");
               $response = $this->json('POST', '/api/auth/token/require', array());
               $response->assertStatus(200);
               $this->assertEquals(4, count($response->json()));
               $this->assertEquals(2, count($response->json()["data"]));
               $this->assertEquals(0, $response->json()['code']);
               $token = $response->json()["data"]["accessToken"];
        
               dump($token);
        
        
               //注册
               $code = 'KaKamfv5';
               $response = $this->reg($token, $code);
               dump($response);
        if (count($response) == 3) {
            $this->assertCount(3, $response);
                
            if ($response['msg'] == '该手机号已注册！') {
                $this->assertEquals(880001, $response['code']);
            } else if ($response['msg'] == '该身份证号码已注册！') {
                $this->assertEquals(880001, $response['code']);
            } else {
                 $this->assertEquals(801010, $response['code']);
            }
                   
        }
        //
        //        dump('开始注册：');
        //        //注册
        //        $code = '345fg76k';
        //        $response = $this->reg($token,$code);
        //        if (count($response) == 3) {
        //            $this->assertCount(3,$response);
        //            if ($response['msg'] == '该手机号已注册！') {
        //                $this->assertEquals(880001,$response['code']);
        //            }
        //        }
        dump('开始注册：');
        //注册
        // $code = '345fg76k';
        // $response = $this->reg($token,$code);
        // if (count($response) == 3) {
        //     $this->assertCount(3,$response);
        //     if ($response['msg'] == '该手机号已注册！') {
        //         $this->assertEquals(880001,$response['code']);
        //     }
        // }
        // $this->assertCount(4,$response);
        // $this->assertEquals(0,$response['code']);
    }

    protected function reg($token, $code)
    {
        //用户注册
        $pwd = "123qwe";
        $paypwd = '1234qweA';
        $data['loginid'] = 'emo';
        $data['nickname'] = 'emo';
        $data['mobile'] = 13263463440;
        $data['name'] = '周涛';
        $data['idno'] = '421126199803263816';
        $data['data'] = $data;
        $response = $this->json(
            'POST', '/api/auth/reg', array(
            "accessToken"=>$token,
            "paypwd"=>$paypwd,
            "pwd"=>$pwd,
            "data"=>$data,
            "code"=>$code
            )
        );
        return $response->json();
    }
}
