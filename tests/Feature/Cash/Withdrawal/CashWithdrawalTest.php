<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class CashWithdrawalTest extends TestCase
{
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
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];
        dump($token);

        $bankid = 6214830121885395;
        dump('用户银行卡'.$bankid);

        //开始登陆
        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->mobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        $withCount = $response['data']['with'];

        //提现
        dump('提现支付密码错误：');
        $amount = rand(0, 1000);
        $bankNo = 1;
        $name = '周涛';
        //        dump('提现金额：'.$amount);
        $paypwd = '123qwe';
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        $this->assertCount(3, $withRes);
        $this->assertEquals(801004, $withRes['code']);


        //提现
        dump('提现小金额：');
        $amount = rand(0, 100);
        dump('提现金额：'.$amount);
        $paypwd = '123qweA';
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        if ($withCount < 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);

                // $this->assertEquals(806007, $withRes['code']);
            }
        } elseif ($withCount == 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
            // $this->assertCount(3, $withRes);
            // $this->assertEquals(806010, $withRes['code']);
        }

        //提现
        dump('提现小数：');
        $amount = rand(100, 1000) . '.' . rand(0, 99);
        // $amount = 100;
        dump('提现金额：'.$amount);
        $paypwd = '123qweA';
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        if ($withCount < 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
        } elseif ($withCount == 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
            // $this->assertCount(3, $withRes);
            // $this->assertEquals(806010, $withRes['code']);
        }

        //提现
        dump('提现卡号带空格：');
        $amount = rand(100, 1000) . '.' . rand(0, 99);
        $bankid = '1820 3587 7740 8143 122';
        dump('用户银行卡'.$bankid);
        dump('提现金额：'.$amount);
        $paypwd = '123qweA';
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        if ($withCount < 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
        } elseif ($withCount == 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }

            // $this->assertCount(3, $withRes);

            // $this->assertEquals(802007, $withRes['code']);
        }

        //提现
        dump('提现卡号带英文：');
        $amount = rand(100, 1000) . '.' . rand(0, 99);
        dump('提现金额：'.$amount);
        $bankid = '18203587774081ll122';
        dump('用户银行卡'.$bankid);
        $paypwd = '123qweA';
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        if ($withCount < 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            }
        } elseif ($withCount == 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
            // $this->assertCount(3, $withRes);
            // $this->assertEquals(802007, $withRes['code']);
        }

        //提现
        dump('提现卡号带中文：');
        $amount = rand(100, 1000) . '.' . rand(0, 99);
        dump('提现金额：'.$amount);
        $paypwd = '123qweA';
        $bankid = '182035中文774081ll122';
        dump('用户银行卡'.$bankid);
        $withRes = $this->with($token, $bankid, $amount, $paypwd, $bankNo, $name);
        dump($withRes);
        if ($withCount < 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
            // $this->assertCount(3, $withRes);
            // $this->assertEquals(808004, $withRes['code']);
        } elseif ($withCount == 2) {
            if (count($withRes) == 4) {
                $this->assertCount(4, $withRes);
                $this->assertEquals(0, $withRes['code']);
            } else {
                $this->assertCount(3, $withRes);
                // $this->assertEquals(806007, $withRes['code']);
            }
            // $this->assertCount(3, $withRes);
            // $this->assertEquals(802007, $withRes['code']);
        }
    }

    protected function with($token, $bankid, $amount, $paypwd, $bankNo, $name)
    {
        $response = $this->json(
            'POST', '/api/cash/withdrawal', array(
            "accessToken"=>$token,
            "amount"=>$amount,
            "bankid"=>$bankid,
            "paypwd"=>$paypwd,
            "name"=>$name,
            "bankNo"=>$bankNo,

            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getSysBankNo($token)
    {
        $response = $this->json(
            'POST', '/api/user/getcashbanklist', array(
            "accessToken"=>$token,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function addUserBank($token, $sysBankType, $bankNo, $phone, $name)
    {
        $bankType = $sysBankType;
        $verfy = '337394';
        $response = $this->json(
            'POST', '/api/user/addbankcard', array(
            "accessToken"=>$token,
            "bank_no"=>$bankNo,
            "bank_name"=>$name,
            "bank_type"=>$bankType,
            "phone"=>$phone,
            "verfy"=>$verfy,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getSysBank($token)
    {
        $response = $this->json(
            'POST', '/api/dic/getbanks', array(
            "accessToken"=>$token,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function getUserBank($token, $pageIndex, $pageSize)
    {
        $response = $this->json(
            'POST', '/api/user/getbankcards', array(
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize

            )
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
