<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;

class MakeAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:add_c_order {address} {amount} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $amount = $this-> argument('amount');;
        $address = $this->argument('address');
        $eth_server = config("ico.eth_server");

        $orderFac = new CompanyOrderData();
        $url= $eth_server . "/creatAccount";
        $payAddress = "121212121212121212";
        if( $eth_server != null){
            $data = HttpHelper::getJson($url);
            $payAddress = $data->newAccount;
        }
        $orderFac -> CreateOrder($name, $amount, $address, $payAddress);
        $this->info("exec success! the {$name} payment address is {$payAddress}");
    }
}
