<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Trade\TranactionOrderData;
use App\Http\Utils\Session;
use App\Http\Utils\RaiseEvent;

/**
 * 执行所有分红计划
 *
 * @author zhoutao
 * @date   2017.11.12
 */
class ExecBonsPlans extends Command
{
    use RaiseEvent;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:execBonusPlans';

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
        $data = new \App\Data\Bonus\BonusPlanData;
        $data->execBonusPlans();
        $this->RaisEvent();
        $this->RaisQueueEvent();
    }
}
