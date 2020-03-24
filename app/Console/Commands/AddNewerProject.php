<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\App\UserInfoData;
use App\Http\Utils\RaiseEvent;
use App\Data\NotifyRun\App\BindingData;

class AddNewerProject extends Command
{
    use RaiseEvent;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:addnewerproject {userid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add newer project';

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
        $userId=$this->argument('userid');
        $userInfoData=new UserInfoData();
        $data=$userInfoData->newitem()->where('kkuserid',$userId)->first();
        $date=date("Y-m-d h:i:s");
        $data->binding_time=$date;
        $data->save();
        $event='updated';
        $data->queueKey=$event;
        $dataArray=$data->toArray();
        $dataArray['params']=json_decode('{"price":0,"coinType":"KKC-BJ0006","count":0.5}', true);
        $bindingData=new BindingData();
        $bindingData->notifyrun($dataArray);
        $this->info('complete');
    }
}
