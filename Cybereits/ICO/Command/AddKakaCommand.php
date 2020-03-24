<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\APIFactory;
class AddKakaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:createorder {name} {amount} {address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '早鸟插队';

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
	    
        $name = $this->   argument('name');
        $amount = $this->argument('amount');
        $address = $this->argument("address");
      
        $orderFac = new OrderData();
        $orderFac-> AddOrder($name , $amount, $address,10);
        $order =$orderFac -> CheckOrder($name, "");
        $order =$orderFac -> AcceptOrder($name, $amount);
        $this->info("exec success!  ".$name);
    }
}
