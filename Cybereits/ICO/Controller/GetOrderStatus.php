<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Common\CommonException;

class GetOrderStatus extends IController
{
    public function run(...$token)
    {
        // dump($token);



        $tokenData = new TokenData();
        $orderData = new OrderData();
        $queryToken = $token[0][0];
        $token = $tokenData -> GetInfo($queryToken);
        $address = $token->address;

        $array = [
        "payaddress"=>$address
      ];

        $order = $orderData ->GetFirst($array);
        if ($order==null) {
            throw new CommonException("没有查到符合要求的信息!", 800030);
        }
     
        $this->Success([
          "address"=>$order->payaddress,
          "min"=>1,
          "scale"=>$order->scale,
	  "name"=>$order->name,
	  "idl4"=>substr($order->idno,strlen($order->idno)-4),
          "lock"=>0,
          "deadline"=> '2018-1-11  0:00:00',
        ]);
    }
}
