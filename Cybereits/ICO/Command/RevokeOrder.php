<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\API\SendCloud;

class RevokeOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:revoke {email} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '开始发起退币申请,发送退币邮件';

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
        $name = $this->argument('email');
        $type = $this->argument('type');



        $orderFac = new OrderData();
        $order =$orderFac -> RequireRevoke($name,$type);
     
        $mail = new SendCloud();
        $mail->SendReturnEmail($order->email,$order->name,$order->idno,$order->accept_amount,$order->scale,$order->payaddress,$order->address);//($order->email, $order->name, $order->payaddress, substr($order->idno, strlen($order->idno)-4), $token,$order->scale,$order->amount);
        
    }
}
