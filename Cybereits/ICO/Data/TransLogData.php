<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Modules\ICO\Data\AddressData;

class TransLogData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\TransLog::class;
    

    public function AddTransLog($from, $to, $amount, $block, $txid, $gas, $coin, $cumulative_gas,$gas_price)
    {
     


        $addInfo = new AddressData();

        $filter = [
            "txid"=>$txid
        ];
        $item = $this->GetFirst($filter);
        if ($item == null) {
            $item = $this->NewItem();
        }
        $item -> from = $from ;
        $item -> to = $to;
        $item -> amount = $amount;
        $item -> blockid = $block;
        $item -> txid = $txid;
        $item -> gas = $gas;
        $item -> coin_type = $coin;
        $item -> cumulative_gas = $cumulative_gas;
		$item -> gas_price = $gas_price ;
		$item -> gas_used = $gas * $gas_price ;
        $item -> save();
        $addInfo -> UpdateBlock($from,$block);
        $addInfo -> UpdateBlock($to,$block);

    }
}
