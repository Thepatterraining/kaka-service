<?php
namespace Cybereits\Modules\COIN\Data;

use Cybereits\Common\DAL\IMySqlModelFactory;
use Cybereits\Common\CommomException;
class TranDocData extends IMySqlModelFactory{
	protected $modelclass = \Cybereits\Modules\Coin\Model\TransDoc::class;
	

	public function CreateTransDoc ($address,$coin_type,$amount,$remark,$type)
	{
		$item =$this->NewItem();
		$item -> address = $address;
		$item -> amount = $amount ;
		$item -> status = 0;
		$item -> remark = $remark;
		$item -> doc_type = $type ;
		$item -> coin_type = $coin_type ;
		$this->Create($item);
		return $item->id;
	}
	

	public function CheckDoc($id){
		
		$filter = [
			"id"=>$id,
			"status"=>0
			];
		$doc = $this->GetFirst($filter);
		if($doc == null ){
			
			throw new CommonException("未查到符合条件的付款单",70001);
		}
		
		$doc->status = 2;
		$this->Save($doc);
    }

	public function GetPayDoc(){
		$filter = [
			"status"=> 2
		];
		$items = $this->Query($filter);
		$result = [];
		foreach($items as $item ){
				$item -> status = 3;
				$this -> Save($item);
				$result[]=[
					"id"=>$item->id,
					"address"=>$item->address,
					"coin_type"=>$item -> coin_type,
					"remark" => $item -> remark ,
				];
		}
		return $result ;
	}
	
	public function DocHasPayed($id){
			
		$filter = [
			"id"=> $id
		];
		$doc = $this->GetFirst($id);
		if($doc == null ){
			throw new CommonException("未查到符合条件的转帐",700002);
		
		}
		$doc -> status = 4;
		$this->Save($doc);	
	}
	
	
	public function UpdateDocTxid($id,$txid){
		$filter = [
			"id"=> $id 
		];
		$doc = $this -> GetFirst($filter);
		if ($doc == null){
			throw new CommonException("未查找符合条件的记录",70003);
		}
		$doc -> status = 5;	
		$doc -> txid = $txid ;
		$this->Save($doc);
	}
}
