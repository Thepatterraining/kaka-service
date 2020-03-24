<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\MessageQueue\RabbitMQ;

class AddQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:addqueue {exchange} {queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add a user a activity group';

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
        $exchangeid = $this->argument('exchange');
        $queueid=$this->argument('queue');
        $rabbitmq=new RabbitMQ;
        $rabbitmq->regPublisher($exchangeid);
        $rabbitmq->subScribe($exchangeid, $queueid);
        $this->info("success");
    }
}