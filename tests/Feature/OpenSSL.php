<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Swift_Signers_SMimeSigner;
use Swift_FileStream;
use Swift_InputByteStream;
use App\Data\API\Payment\Ulpay\CheckSignUtil;
use App\Data\API\Payment\Ulpay\EncoderUtils;
use App\Data\Utils\DocNoMaker;
use App\Data\API\Payment\Ulpay\PayService;

use App\Data\API\Payment\PaymentServiceFactory ; 
class OpenSSL extends TestCase
{

    /*
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {



        $serviceFac = new PaymentServiceFactory();
        $docNo = DocNoMaker::getDateSerial("Test", "T", 3);
       
        $pay = $serviceFac->createService();



        $cardno = "6222000200126624709";

        $cardno = "6225881010728375";
        $mobileno = "13521510781";
    
         $result = $pay->GetBankCardInfo($cardno);//,"葛云飞","231124198405022117", $mobileno);
        // 
        dump($result);
        /*

        $date = date("Ymd");
        $result = $pay->PreparePay(     $docNo,$date,2);
        dump($result);

         $result = $pay->RequireSms($docNo, $mobileno);
        dump($result);


        fwrite(STDOUT,'请输入验证码：');
        $code = fgets(STDIN);
         
        $result = $pay-> ConfirmPay($docNo,$date,3, $cardno,"葛云飞","231124198405022117", $mobileno
        ,         $code); 


        dump($result);*/
        $this->assertTrue(true);

    }
 
}
