<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Data\Report\ReportSettlementMonthListData;

class MakeListAdapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:makemonthsettlement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make month settlement';

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
     /**
      * 运行月报表
      *
      * @author liu
      * @date   2017.9.14
      */ 
    public function handle()
    {
        $reportSettlementMonthListData=new ReportSettlementMonthListData;
        $reportSettlementMonthListData->run();
    }
}
