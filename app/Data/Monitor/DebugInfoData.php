<?php
namespace App\Data\Monitor;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\Schedule\IDaySchedule;

class DebugInfoData extends IDatafactory implements IDaySchedule
{
     
    protected $modelclass = 'App\Model\Monitor\DebugInfo';

    public function __construct()
    {
        $config = config('log.mongoDeBug');
        if ($config === true) {
            $this->modelclass = 'App\Model\Monitor\MongoDebugInfo';
        }
    }

    public function clearBefore($date)
    {
        DB::connection()->statement("delete from sys_debug where created_at <\"{$date}\"");
    }

    public function run()
    {
        $end = date("Y-m-d 00:00:00");
        $lastWeek = date_create($end);
        $lastWeek = date_format($lastWeek, 'Y-m-d H:i:s');
        $this->clearBefore($lastWeek);
    }
}
