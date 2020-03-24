<?php

namespace Cybereits\Application\Command;

use Illuminate\Console\Command;
use Cybereits\Application\Data\AppFac;

class AppRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cyber:release {name} {version} {download}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发布一个应用';

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

      $name = $this->argument("name");
      $version = $this->argument("version");
      $url = $this->argument("download");

    
      try{
        $fac = new AppFac;
        $fac -> pushRelease($name,$version,"",$url);
      }catch(Exception $e){

      }
	

		
	    
	}
} 
