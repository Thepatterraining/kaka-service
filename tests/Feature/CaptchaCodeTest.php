<?php
namespace Tests\Feature;

use Gregwar\Captcha\CaptchaBuilder;
//use Intervention\Image\Response;
use Mews\Captcha\Facades\Captcha;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use Illuminate\Http\Response;

class CaptchaCodeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testAddActivityConfig()
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



        $response = $this->getCode($token);
        dump($response);
    }

    protected function base64EncodeImage($image_file)
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    protected function getCode($token)
    {
        $response = $this->json(
            'POST', '/api/auth/getcode', [
            "accessToken"=>$token,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
