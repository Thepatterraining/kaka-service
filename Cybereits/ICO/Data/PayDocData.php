<?php
namespace Cybereits\Modules\ICO\Data;

use Cybereits\Common\DAL\IMySqlModelFactory ;
use Cybereits\Common\CommonException;
use Cybereits\Modules\ICO\Data\CommunityData;
use Cybereits\Modules\ICO\Data\WaletData;
use cybereits\Modules\ICO\Data\TokenData;
use Illuminate\Support\Facades\DB;

/**
 * Pay Doc Data 
 * @author geyunfei <geyunfei@gmail.com>
 * @date Jan 18th,2018
 */

class PayDocData extends IMySqlModelFactory
{
    protected $modelclass = \Cybereits\Modules\ICO\Model\PayDoc::class;
    /**
     * create the doc 
     */
    public function AddDoc($address,$txid,$amount){
	$item = $this->NewItem();
	$item -> address = $address;
	$item -> to_return  = $amount;
	$item -> txid = $txid;
	$item -> status = 0;
	$this->Create($item);
    }
}
