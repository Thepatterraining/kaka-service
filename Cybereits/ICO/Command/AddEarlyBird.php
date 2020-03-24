<?php

namespace Cybereits\Modules\ICO\Command;

use Illuminate\Console\Command;
use Cybereits\Common\Utils\HttpHelper;
use Cybereits\Modules\ICO\Data\CompanyOrderData;
use  Cybereits\Modules\ICO\Data\OrderData;
use Cybereits\Modules\ICO\Data\TokenData;
use Cybereits\Modules\KYC\APIFactory;

class AddEarlyBird extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:early {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '批量早鸟插入命令. 参数: 份数';

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
        $eth_server = config("ico.eth_server");
        $orderFac = new OrderData();
	$url= $eth_server . "/creatAccount";
        $count = $this->argument("count");
        for ($i =0 ;$i < $count; $i ++) {
            $this->info('处理��'.$i);
            if ($eth_server != null) {
                $data = HttpHelper::getJson($url);
                $payAddress = $data->newAccount;
                $this->info("内部地址:".$payAddress);
	        $user_name = "cyber_".$i."_".substr($payAddress,4,4);
		$this->info($user_name);
                $orderFac-> AddOrder($user_name, 5, $payAddress, 7);
                $this->info("审核地址...");
                $order =$orderFac -> CheckOrder($user_name, "");
                $this->info("审核订单...");
                $order =$orderFac -> AcceptOrder($user_name, 5);
            }
        }
        $this->info("处理完成,将.env中ICO_PROGRESS和ICO_SENDTYPE改为7即可由eth server 进行处理!");
    }
}
