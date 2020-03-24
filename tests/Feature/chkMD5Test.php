<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Utils\XmlHelper;
use App\Data\API\Payment\OpenSwiftWechat;
use Illuminate\Support\Facades\Log;
use App\Data\API\Payment\PaymentFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Data\API\Payment\OpenSwiftSettelment;
use App\Data\API\Payment\OpenSwiftAlipay;

class chkMD5Test extends TestCase
{


 
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {



      
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
        $fac = new PaymentFactory();

        $pay =new OpenSwiftAlipay(); 
        // $fac->create("swift.jspay");
        $now = date('YmdHis');

        $msg = $pay->reqPay(1, $now, 2);
    

        // 
        dump($msg);


        /*

        $settlemnet = new OpenSwiftSettelment();


        foreach (["20170521","20170522","20170523","20170524"] as $time) {
            $str = $settlemnet->getSettelment($time);

            $file = fopen($time.".csv", 'w');
            fwrite($file, "\xEF\xBB\xBF".$str);
            fclose($file);
        }
    
  




 
       

   
        //dump($pay->getSettelment（"20170522");checkSign($str));
        // $json = XmlHelper::decode($str);
        // dump($json);
 
        /*
        $now = date('YmdHis');
        $exp = date('YmdHis',strtotime("+10 minute"));

        $obj = array();
        $obj["service"]= "pay.weixin.native";
        $obj["version"]= "2.0";
        $obj["charset"]= "UTF-8";
        $obj["sign_type"]= "MD5";
        $obj["mch_id"]= "105580006455";
        $obj["out_trade_no"]= "1861231232641";
        $obj["device_info"]= "001";
        $obj["body"] = "充值";
        $obj["attach"]= "kakamf";
        $obj["total_fee"]= "100";
        $obj["mch_create_ip"]= "127.0.0.1";
        $obj["notify_url"]= "www.kakamf.com";
        $obj["time_start"]=  $now;
        $obj["time_expire"]= $exp;
        $obj["nonce_str"]= "helloworld";
        // $obj["sign"]= "";
        ksort($obj);

        $str2Md5 = "";
        foreach($obj as $key => $val){
            $str2Md5 = $str2Md5."&".$key."=".$val;
        }

        $str2Md5 = substr($str2Md5,1);
        $obj["sign"]=strtoupper(MD5($str2Md5."&key=98955ba5c937c6f4c51c93d4eb347d17"));


        $sendXML = $this->arrayToXml($obj);
        dump($sendXML);
        dump($obj);
        $req = $this->execReq($sendXML);
        dump($req->body);

                $this->assertTrue(true);*/
    }

    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    private function execReq($body)
    {

        $url = "https://pay.swiftpass.cn/pay/gateway";///"/api/exchanges/".config("rabbitmq.hostname")."/".$exchangeid;//; kk.php.service";
        // dump($sendStr);l
        dump($url);
        $req = \Httpful\Request::post($url)->body($body);
        //            ->sendsJson()
        // ->authenticateWith(config("rabbitmq.user"),config("rabbitmq.pwd"))
        //  ; //    ->body($sendStr);
        //  if($body != null){
        //               $sendStr = json_encode($body);
        //$req = $req->body($sendStr);
        // }
        // $req->addHeader(
        //      "Accept",
        //      "application/json"
        // );
        $res = $req ->send();
        return $res;
    }
}
