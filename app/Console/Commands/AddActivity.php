<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Data\User\UserData;
use App\Data\Activity\RegVoucherData;
use App\Data\Activity\InfoData;
use Illuminate\Support\Facades\Redis;


class AddActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:activityadd {user} {invcode}';

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
         $userid = $this->argument('user');
         $invcode = $this->argument('invcode');

         $userdata = new UserData();
         $voucherData  = new RegVoucherData();
         

         $userInfo = $userdata->getUser($userid);
        if ($userInfo == null) {
            $this->error('没有发现用户');
        }
         $infoData = new InfoData();
         $info = $infoData->getCodeInfo($invcode);
        if ($info == null) {
            $this->error("没有查到活动");
        }
         $infoData->addUserActivity($info->activity_no, $userInfo->id);

        
    }
}
