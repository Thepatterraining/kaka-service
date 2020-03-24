<?php
namespace Cybereits\Modules\ICO\Controller;

use Cybereits\Http\IController;

use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Adapter\CommunityAapter ;
use Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\KYC\Data\IDInfoData;
use Cybereits\Modules\ICO\Data\TransLogData;
use Cybereits\Modules\ICO\Data\WaletData;

class PostTrans extends IController
{
    public function run()
    {
        $trans= new TransLogData();
        
		$data = $this->request->input("data.trans");
        $address = $this->request->input("data.address");
		$eth = $this->request->input("data.eth");
		$cre = $this->request->input("data.cre");
 		$walet = new WaletData();
        $walet -> UpdateAmount($address, $eth,"ETH");
		$walet -> UpdateAmount($address, $cre,"CRE");
        foreach ($data as $item) {
            $from =$item["from"];
            $to=$item["to"];
            if (array_key_exists('amount', $item)) {
                $amount = $item["amount"];
            } else {
                $amount = 0;
            }
            if (array_key_exists('block', $item)) {
                $block = $item["block"];
            } else {
                $block = 0 ;
            }
            $txid = $item ["txid"];
            $gas = $item ['gasUsed'];
	    	$gastotal = $item ["cumulativeGasUsed"];
			$eth = $item   ["ethTransferred"];
			$token = $item ["tokenTransferred"];
		    if($eth != "0" && $eth != 0)
            {
				$trans->AddTransLog($from, $to, $eth, $block, $txid, $gas, "ETH",$gastotal);
			}
			if($token != "0" &&  $token != 0){
				$trans->AddTransLog($from,$to, $token,$block,$txid,$gas, "CRE",$gastotal);
			}
        }
    
        $this->Success();
    }
}
