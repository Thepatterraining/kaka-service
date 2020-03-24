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

class GetNewTest extends TestCase
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

        $newData = new \App\Data\Sys\NewsData;
        $new = $newData->find();
        if (!empty($new)) {
            $no = $new->news_no;
            $response = $this->getNews($token, $no);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        
    }

    protected function getNews($token, $no)
    {
        $response = $this->json(
            'POST', '/api/user/getnewsinfo', array(
            "accessToken"=>$token,
            "no"=>$no
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
