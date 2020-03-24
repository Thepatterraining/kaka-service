<?php
namespace Cybereits\Modules\COIN\Data;

use Cybereits\Common\DAL\IMySqlModelFactory;
use Cybereits\Common\CommomException;
use Illuminate\Support\Facades\DB;
class InternalTransData extends IMySqlModelFactory
{
 protected $modelclass = \Cybereits\Modules\COIN\Model\InternalTrans::class;

  /**
   * create a internal transfer 
   * @author geyunfei
   * @date Feb 10th,2018
   */
  public function CreateDoc($from,$to,$coinType,$amount){
	$doc = $this->NewItem();
	$doc->from = $from ;
	$doc->to = $to;
	$doc->coin_type = $coinType;
	$doc->coin_amount = $amount ;
	$doc->state = 0;
	$doc->trans_type = 0;
	$this->Create($doc);
	return $doc;
  }
  public function Check($docid){
	$filter = [
	"id"=>$docid,
	"state"=>0
	];
	$item = $this->GetFirst($filter);
	if($item === null ){
		throw new CommonException(9,"");
	}

	$item -> state =1;
	$this->Save($item);
	
  }
  

  public function GetToTrans($count=10){
	$filter = [
		"state"=> 1
		];
	if($count == 0)
		$count = 10;
		$queryResult  =  $this->queryWithPaging($filter, $count, 1);
        $items = $queryResult ["items"];
        $result = [];
        DB::beginTransaction();
        foreach ($items as $item) {
            $r_item =  (Object)[
                "address"=>$item->from,
                "amount"=>$item->coin_amount,
				"coin_type"=>$item->coin_type,
				"id"=>$item->id,
            ];
	   		$result []=$r_item;	
       		$item->state = 3;
            $item->save();
            info("return address ".$item->address." to discoin.");
        }
        DB::commit();
		return $result ;
  }
  public function __UpdateState($docid){

  }
  public function UpdateStatus($txid,$from,$to,$amount,$coin_type){
	
	}		
 
}
