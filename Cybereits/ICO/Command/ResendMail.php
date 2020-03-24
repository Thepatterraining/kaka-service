<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;

class ResendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:resendAdd {email}';

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

        $orderFac = new OrderData();
        $order =$orderFac -> GetOrder($name,1);
        $mail = new SendCloud();
	//SendAcceptEmail($email, $name, $idno, $acc_amount, $address,$cre)
        $mail->SendAcceptEmail($order->email, $order->name, $order->idno, $order->accept_amount,$order->address,$order->scale);

       //  $this->info("exec success! the {$name} payment address is {$payAddress}");
    }
}
