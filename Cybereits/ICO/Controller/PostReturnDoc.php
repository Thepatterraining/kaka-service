<?php
namespace Cybereits\Modules\ICO\Controller ;

use Cybereits\Http\IController;
use Cybereits\Modules\ICO\Data\PayDocData;
/**
 * post the return eth info .
 * @author geyunfei <geyunfei@gmail.com>
 * @version 1.0
 * @data Jan 18th,2018
 **/


class PostReturnDoc extends IController
{
    public function run()
    {

	$fac = new PayDocData();

        

        $data = $this->request->input("data");
        foreach($data as $item ){
          $address =$item["address"];
          $amount =$item["amount"];
	  $txid = $item["txid"];
	  info('return '.$address.' amount:'.$amount.' txid: '.$txid);
          $fac-> AddDoc($address,$txid, $amount);
        }
    
        $this->Success();
    }
}
