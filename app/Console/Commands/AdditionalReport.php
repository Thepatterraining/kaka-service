<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AdditionalReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:addreport {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Report';

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

        $date = $this->argument('date');
    }
}
