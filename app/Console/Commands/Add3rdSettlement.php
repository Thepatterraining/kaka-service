<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Data\User\UserData;
use App\Data\Activity\RegVoucherData;
use App\Data\Cash\UserRechargeData;
use App\Data\Activity\InfoData;

class Add3rdSettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:settlement {start} {end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add a user a activity ';

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

         $start = $this->argument('start');
         $end = $this->argument('end');
         $userRechargeData = new UserRechargeData();

         $start=date($start);
         $end=date($end);
         $endDate=date_create($end);
         $tmp_start=date_create($start);
         $tmp_end=date_create($start);
         date_add($tmp_end, date_interval_create_from_date_string("1 days"));

         dump($end);
        //  $voucherData  = new RegVoucherData();
        while($tmp_start!=$endDate)
         {
            $userRechargeData->ThirdPartyRechargeIncomedocs($tmp_start, $tmp_end, 5);
            date_add($tmp_start, date_interval_create_from_date_string("1 days"));
            date_add($tmp_end, date_interval_create_from_date_string("1 days"));
            dump($tmp_start);
        }
        //
    }
}
