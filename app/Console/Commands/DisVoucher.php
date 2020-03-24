<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Activity\InfoData;
use App\Data\User\UserData;

class DisVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:disvoucher {id} {act}';

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
    public function handle()
    {

             $userid = $this->argument('id');
             $actid = $this->argument('act');
             $infodata = new InfoData();
             if ($userid > 0) {
                $infodata->addUserActivity($actid, $userid);
                return $this->info('发券成功！');
            }

            //给所有人发
            $userData = new UserData;
            $model = $userData->newitem();
            $model->chunk(100,function($users){
                foreach($users as $user) {
                    $actid = $this->argument('act');
                    $infodata = new InfoData();
                    $infodata->addUserActivity($actid, $user->id);
                    $this->info($user->id);
                }
            });
            return $this->info('发券成功！');
              
        //
    }
}
