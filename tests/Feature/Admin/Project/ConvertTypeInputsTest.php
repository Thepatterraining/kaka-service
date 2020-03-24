<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class ConvertTypeInputsTest extends TestCase
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

        //查询用户菜单
        dump('查询用户菜单');
        $typeid =1;
        $response = $this->getList($token, $typeid);
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

    protected function getList($token, $typeid)
    {
        $response = $this->json(
            'POST', '/api/admin/project/converttypeinputs', array(
            "accessToken"=>$token,
            "items"=>[
                "房屋类型"=>"一居室",
                "房屋年代"=>"1990",
                "房屋建筑面积"=>"44.7",
                "房屋属权" => '商品房',
                '房屋用途' => '普通住宅',
                '房屋位置' => '北京市西城区六铺炕一区',
                '区域介绍' => '六铺炕小区对应西城区的教育资源最为优厚，北京西城区师范学校附属小学仅一步之遥。中学教育资源更是西城区最佳的配置，包括北京三帆中学、北京师范大学第二附属中学西城实验学校、三帆中学裕中校区、北京第四中学、北京第八中学、北京第十三中学、北京第七中学等优质教育资源，教育实力极为雄厚；周边临近华联商厦、翠微百货、新华百货、北京积水潭医院、北京安贞医院、火箭军总医院、工商银行、北京银行、华夏银行等公共场所， 配套设施完善，生活十分便利。',
                '交通位置' => '六铺炕小区紧邻北二环外，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵。交通极其便利，距8号线安德里北街站仅300米，距2号线鼓楼大街地铁站仅800米。'
            ],
            "coinType" => 'KKC-BJ0006',
            'name' => '西城房产005号',
            'scale' => 0.01,
            'coinAmmount' => 44.70,
            'startTime' => '2017-11-13 00:00:00',
            'score' => [
                "租金回报" => 2,
                "升值空间" => 5,
                "地理位置" => 5,
                "交通便利" => 4,
                "教育属性" => 5,
            ],
            'investsType' => 4,
            'status' => 1, //无
            'proceeds' => [
                2,1
            ],
            'tags' => [
                7
            ],
            'annualRate' => [
                [
                    'year' => 2012,
                    'rate' => 70.75,
                    'isHistory' => 1,
                    'primary' => 0,
                ],
                [
                    'year' => 2013,
                    'rate' => 18.90,
                    'isHistory' => 1,
                    'primary' => 0,
                ],
                [
                    'year' => 2014,
                    'rate' => 1.26,
                    'isHistory' => 1,
                    'primary' => 0,
                ],
                [
                    'year' => 2015,
                    'rate' => 29.58,
                    'isHistory' => 1,
                    'primary' => 0,
                ],
                [
                    'year' => 2016,
                    'rate' => 43.90,
                    'isHistory' => 1,
                    'primary' => 0,
                ],
                [
                    'year' => 0,
                    'rate' => 100,
                    'isHistory' => 1,
                    'primary' => 1,
                ],
            ],
            'bonusType' => 4,
            'bonusPeriods' => 7,
            'guidingPrice' => 1555,
            'holds' => [
                'id' => 1,
                'type' => 0,
                'holdLast' => '2017-11-20',
                'details' => [
                    [
                        'id' => 1,
                        'capital' => 200,
                        'holderTypeName' => '分红',
                        'shareBonus'=> 1,
                    ],
                ],
            ],
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

}
