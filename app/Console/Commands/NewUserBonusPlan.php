<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Utils\Session;
use App\Data\Coin\SysCoinAccountRechageData;
use App\Data\Bonus\ProjBonusPlanData;

/**
 * 创建分红计划
 *
 * @author zhoutao
 * @date   2017.11.15
 */
class NewUserBonusPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:newUserBonusPlan {coinType} {fee} {cash} {typeid} {startTime} {endTime} {startIndex}';

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
        $fee = $this->argument('fee');
        $cash = $this->argument('cash');
        $typeid = $this->argument('typeid');
        $startTime = $this->argument('startTime');
        $endTime = $this->argument('endTime');
        $startIndex = $this->argument('startIndex');

        $projBonusPlanData = new ProjBonusPlanData;
        $projBonusPlanData->add($coinType, $fee, $cash, 0.01, 1, $typeid, $startTime, $endTime, $startIndex);

        $this->info('ok');
    }
}
