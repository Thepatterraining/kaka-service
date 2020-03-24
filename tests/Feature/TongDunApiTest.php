<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class TongDunApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testTongdun()
    {
        // dump('测试开始');

        // $name = '郑志';
        // $idno = '130425199903034914';
        // $this->tongDunApi($name,$idno);
      $this->tongDunApi("郑帅","130406199011200623");
        //$this->tongDunApi("葛飞","231124198405022117");
    }

    public function tongDunApi($name, $idno)
    {
        $array = [
            'name'=>$name,
            'id_number'=>$idno,
        ];
        $sign = self::sign($array, 'kakamaifang');
        $array['auth_code'] = $sign;
        $url = 'https://apiv2.lomocoin.com/v1/kaka/verify';
        $data = $this->curlGet($url, $array);

        $data = json_decode($data);

        dump($data);

        if ($data->status == 200) {
            if ($data->result->status == true) {
                dump(true);
            } elseif ($data->result->status == false) {
                dump(false);
            }
        }
    }

    public function curlGet($url, $_aryData)
    {
        $url = $url . '?' . http_build_query($_aryData);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_HEADER, 0);

        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }

    public static function sign($_aryData, $_strSignKey = "")
    {
        // 将KEY添加到合并数据
        $_aryData[] = $_strSignKey;
        sort($_aryData, SORT_STRING);
        // 合并数据
        $sign = implode("_", $_aryData);
        // 将字符串签名，获得签名结果
        $sign = md5($sign);
        return $sign;
    }

    protected function appBind($token, $openid, $appid, $data = [])
    {
        $response = $this->json(
            'POST', '/api/wechat/appbind', [
            "accessToken"=>$token,
            'openid'=>$openid,
            'appid'=>$appid,
            'data'=>$data,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
