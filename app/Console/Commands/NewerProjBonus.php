<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NewerProjBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:newer_bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Newer-Project Bonus';

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
        
    }
}
