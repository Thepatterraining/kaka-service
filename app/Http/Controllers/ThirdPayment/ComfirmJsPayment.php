<?php
namespace App\Http\Controllers\ThirdPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\XmlHelper ;
use App\Data\API\Payment\OpenSwiftWechat;
use Illuminate\Support\Facades\Log;
use App\Data\Product\InfoData;
use App\Data\Product\PreOrderData;
use App\Data\CashRecharge\CashRechargeFactory;

class ComfirmJsPayment extends Controller
{
    
    protected $json  = false;
    public function run(...$param)
    {
        
        $message = file_get_contents('php://input');
        Log::info($message);
        if (count($param[0])==0) {
            $this->result = "error";
        } else {
            $paymethod = $param[0][0];
            $pay = new OpenSwiftWechat();
            $result = $pay->getPostResult($message);
            if ($result -> result === true) {
                $rechargeNo = $result->rechargeNo;
                
                $chkStr =  strpos($rechargeNo, "CR");
                $channelID =  $result->channelId ;
                
                if ($chkStr === false) {
                    // 预购
                    
                    $infoData = new InfoData();
                    $preorderData = new PreOrderData();
                    $preorderData->wechatBuyProduct($rechargeNo, $channelID);
                } else {
                    //recharge
                    $rechargeFac = new CashRechargeFactory;
                    $rechargeData = $rechargeFac->createData($channelID);
                    $rechargeData->rechargeTrue($rechargeNo);
                }
              
                $this->result = "success";
            } else {
                $this->result = "error";
            }
        }
    }
}
