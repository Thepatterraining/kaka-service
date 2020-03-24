<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class GetQueueTest extends TestCase
{
    public function testGetQueue()
    {
        dump('测试开始');
        // dump("Require Token:");
        // $response = $this->json('POST', '/api/auth/token/require', array());
        // $response->assertStatus(200);
        // $this->assertEquals(4, count($response->json()));
        // $this->assertEquals(2, count($response->json()["data"]));
        // $this->assertEquals(0, $response->json()['code']);
        // $token = $response->json()["data"]["accessToken"];
        // dump($token);

        //查看队列详细信息
        dump('查看队列详细信息');
        $queue="kk_event";
        $response = $this->getItemInfo($queue);
        dump($response);
        if (count($response) == 4) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        } else {
            $this->assertCount(3, $response);
            $this->assertEquals(802006, $response['code']);
        }
    }

    protected function getItemInfo($queue)
    {
        $response = $this->json(
            'POST', '/api/withoutmid/queue/getqueue', [   
                "queue"=>$queue,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
