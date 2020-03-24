<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Utils\Session;
use App\Data\Coin\SysCoinAccountRechageData;

/**
 * 给系统充值代币
 *
 * @author zhoutao
 * @date   2017.11.9
 */
class SysCoinRecharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:sysCoinRecharge {coinType} {count}';

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

        $coinType = $this->argument('coinType');
        $count = $this->argument('count');

        $data = new SysCoinAccountRechageData;
        $recharNo = $data->recharge($coinType, $count);
        $data->rechargeTrue($recharNo);

        $this->info('ok');
    }
}
