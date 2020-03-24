<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\APIFactory;
class CheckAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:check_add {email}';

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
	    
        $name = $this->   argument('email');
        $eth_server = config("ico.eth_server");

        $orderFac = new OrderData();
        $url= $eth_server . "/creatAccount";
        $payAddress = "121212121212121212";
        if ($eth_server != null) {
            $data = HttpHelper::getJson($url);
            $payAddress = $data->newAccount;
        }
        $order =$orderFac -> CheckOrder($name, $payAddress);
        $tokenData = new TokenData();
        $token = $tokenData->CreateToken($name, $payAddress);
	    $apifac = new APIFactory();
        $mail =$apifac->CreateSendMailLogic(); 
        $mail->SendAddressEmail($order->email, $order->name, $order->address, substr($order->idno, strlen($order->idno)-4), $token, $order->scale,$order->amount);

        $this->info("exec success! the {$name} payment address is {$payAddress}");
    }
}
