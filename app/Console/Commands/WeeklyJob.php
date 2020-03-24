<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Data\Schedule\ScheduleItemData;

class WeeklyJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Weekly DataSheet';

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

        $end = date("Y-m-d H:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 week"));
        $scheduleItemData=new ScheduleItemData();
        $scheduleItemData->createWeeklyJob();

    }
}
