<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use Illuminate\Support\Facades\DB;

class GetReturn  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:showreturn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the address to return ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	$items = $this->GetReturns(0);
    }
    private function GetReturns ($count ){
	$sql = "select name,mobile,email,idno,ico_order.address reg_address, ico_order.payaddress sys_address, ico_order.amount reg_amount,ico_order.accept_amount ,coin_sys_address_amount.address_amount receive_amount from ico_order,coin_sys_address_amount where ico_order.payaddress = coin_sys_address_amount.address and ico_order.order_type = 1 and coin_sys_address_amount.address_amount > ico_order.accept_amount ";
	if(is_numeric($count) && $count > 0){
		$sql = $sql . "take ".$count ;
	}
	$items = DB::select ($sql);
	return $items;
   }
	
}
