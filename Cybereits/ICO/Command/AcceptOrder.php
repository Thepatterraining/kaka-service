<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\APIFactory;
use Cybereits\Common\CommonException;

class AcceptOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ico:accept_order {email} {amount}';

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

      try {
          $email = $this->   argument('email');
          $amount = $this-> argument('amount');
          $orderFac = new OrderData();
          $order =$orderFac -> AcceptOrder($email, $amount);
	  $apifac = new APIFactory();
          $send =$apifac->CreateSendMailLogic(); 
          $send->SendAcceptEmail($email, $order->name, $order->idno, $amount, $order->address,$order->scale,$order->amount);
      }catch (CommonException $ex){
          $this->error($ex->Msg);
      }
       $this->info("exec success! the {$email} has sent.{$amount}");
    }
}
