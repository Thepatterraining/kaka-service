<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Data\Cash\UserRechargeData;

class MakeThiredIncomeDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:thirdpaydoc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MakeThirdPayDoc';

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
 
      
        //
    }
}
