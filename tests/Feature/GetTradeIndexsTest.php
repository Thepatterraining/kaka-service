<?php
namespace Tests\Feature;

use App\Data\Sys\ErrorData;
use App\Data\Sys\LoginLogData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetTradeIndexsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddMobileLogin()
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

        //查询k线
        dump('查询k线');
        $type = 'day';
        $coinType = 'KKC-BJ0001';
        $start = "2017-08-17 5:00:00";//date('Y-m-d',strtotime('-1 day'));
        $end = "2017-08-24";//date('Y-m-d',strtotime('+1 day'));
        $response = $this->getTradeIndexs($token, $type, $coinType, $start, $end);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
    }

    protected function getTradeIndexs($token, $type, $coinType, $start, $end)
    {
        $response = $this->json(
            'POST', '/api/token/trade/gettradeindexes', array(
            "accessToken"=>$token,
            "type"=>$type,
            "coinType"=>$coinType,
            "start"=>$start,
            "end"=>$end,
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
