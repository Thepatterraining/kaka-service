<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;

use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\KYC\Data\IDInfoData;


class PostOrder extends IController
{
    public function run()
    {
        $idfac = new IDInfoData;
        $orderData = new OrderData();
        $email = $this->request->input("email");
        $checkcode =$this->request->input("checkcode");
        info($checkcode);
	$name = $this->request -> input("name");
        $id = $this->request -> input("idno");
        $mobile = $this->request -> input("mobile");
        $community_id = $this->request -> input("community_id");
        $amount =  $this->request -> input("ethcount");
        $address =  $this->request -> input("ethaddress");
        $wechat = $this->request -> input("wechat");
        $idfac -> RegIDInfo($name, $id, $mobile, $email, $checkcode, $address);
        $index = $orderData -> CreateOrder($id, $name, $email, $mobile, $community_id, $amount, $address, $wechat);
        $this->Success();
    }
}
