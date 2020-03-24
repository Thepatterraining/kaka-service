<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Data\Sys\ApplicationData;

class NewApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:newapp {appName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新生成一个应用/临时';

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
      $appName = $this->argument("appName");
      $version = "1.0";
      $remark = "测试";

      $app_data = new ApplicationData;
      $res = $app_data->add($appName,$version,$remark);

      dump($res);


    }
}
