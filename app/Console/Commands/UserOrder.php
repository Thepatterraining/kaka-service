<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;

class UserOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:userOrder';

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
    public function handle(Session $session)
    {
        $transactionOrderData = new TranactionOrderData();
        $date = date('Y-m-d H:i:s');
        $session->userid = 352;
        dump($session);
        $count = $transactionOrderData->buyProduct(1, 1550, 'TB2017060622164789057', 'TS2017052109583153953', 'VCS2017060620503163956', $date);
        $this->info('ok!');
    }
}
