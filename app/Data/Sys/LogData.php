<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\Schedule\IDaySchedule;
use App\Data\Notify\INotifyDefault;
use App\Data\Notify\INotifyData;
use App\Mail\DBErrorReport;
use Illuminate\Support\Facades\Mail;

class LogData extends IDatafactory implements IDaySchedule
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\Log';

    public function __construct()
    {
        $config = config('log.mongoLog');
        if ($config === true) {
            $this->modelclass = 'App\Model\Sys\MongoLog';
        }
    }

    public function create($item)
    {
        if (!empty($this->session)) {
            $item->token = $this->session->token;
        }
        if ($item->dumpinfo==null) {
            $item->dumpinfo  = "";
        }
        parent::create($item);
        
    }

    public function clearBefore($date)
    {
        DB::connection()->statement("delete from sys_log where created_at <\"{$date}\"");
    }

    public function run()
    {
        $end = date("Y-m-d 00:00:00");
        $lastWeek = date_create($end);
        
        date_add($lastWeek, date_interval_create_from_date_string("-7 days"));
        $lastWeek = date_format($lastWeek, 'Y-m-d H:i:s');
        $this->clearBefore($lastWeek);
    }

    // public function notifycreateddefaultrun($data)
    // {
    //     $notifyData=new INotifyData();
    //     $event='NY07';
    //     $notifyData->doJob($event,$data["dumpinfo"],null,$data["created_at"]);
    //     return true;
    // }

    // public function notifysaveddefaultrun($data)
    // {
          
    // }

    // public function notifydeleteddefaultrun($data)
    // {

    // }

    public function notifyemailrun($address,$name,$notifyName,$attach)
    {
        return Mail::to([$address])->send(new DBErrorReport($attach['dumpinfo']));
    }
}
