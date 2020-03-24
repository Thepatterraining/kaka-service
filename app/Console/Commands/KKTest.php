<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Utils\RaiseEvent;

class KKTest extends Command
{


    use RaiseEvent;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用于测试';

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
        $this->AddEvent('NewUser_Bonus_Check',5825,16657);
        //
        $this->RaisEvent();
       // $this->assertTrue(true); 
    }
}

