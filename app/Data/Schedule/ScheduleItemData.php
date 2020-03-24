<?php
namespace App\Data\Schedule;
use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use Illuminate\Support\Facades\DB;
use App\Data\Schedule\ISchedule;
//use App\Data\Report\ReportUserrbSubDayData;
//use App\Data\ScheduleDefineData;

class ScheduleItemData extends IDataFactory
{

    protected $modelclass = 'App\Model\Schedule\ScheduleItem';

    const STATUS_INIT = "JST01";
    const STATUS_EXCUTE="JST02";
    const STATUS_SUCCESS = "JST03";
    const STATUS_FAIL = "JST04";

    const SCHEDULE_HOUR="SCH01";
    const SCHEDULE_DAY="SCH02";
    const SCHEDULE_WEEK="SCH03";
    const SCHEDULE_MONTH="SCH04";
    const SCHEDULE_DEFAULT="SCH05";
    const SCHEDULE_MINUTE="SCH06";

    public function getJob($defineNo,$jobItemName)
    {
        $item = $this->newitem();
        $result = $item->orderBy('sch_start', 'desc')->where('sch_defno', $defineNo)->first();
        return $result;
    }

    public function createJobItemName($scheduleDefine)
    {

        //$name = $scheduleDefine->sch_type.$scheduleDefine->sch_no
    

        if($scheduleDefine->sch_type==self::SCHEDULE_DAY) {
                return '定时任务-'.$scheduleDefine->sch_no.date("-Y年m月d日");
        }
        else if($scheduleDefine->sch_type==self::SCHEDULE_HOUR) {
                return '定时任务-'.$scheduleDefine->sch_no.date("-Y年m月d日 H:00:00");
        }
        else if($scheduleDefine->sch_type==self::SCHEDULE_WEEK) {
                return '定时任务-'.$scheduleDefine->sch_no.date("-Y年W周");
        }
        else if($scheduleDefine->sch_type==self::SCHEDULE_MONTH) {
               return '定时任务-'.$scheduleDefine->sch_no.date("-Y年m月");
        }
        else if($scheduleDefine->sch_type==self::SCHEDULE_MINUTE) {
               return '定时任务-'.$scheduleDefine->sch_no.date("-Y年m月d日 H:i:00");  
        }
        else {
                return "自定义".DocNoMaker::Generate("SCHJ");

        }
    }

    public function createDailyJob()
    {
        
        $scheduleDefineData=new ScheduleDefineData();
        $scheduleDefine=$scheduleDefineData->getScheduleDefine();
        $time=time();
        // dump($time);
        foreach($scheduleDefine as $define){
            // dump($define->sch_name);
            if($define->sch_type==self::SCHEDULE_DAY) {

                $defineType=$define->sch_type;
                $defineNo=$define->sch_no;
                $jobName = $this->createJobItemName($define);
                $item = $this->getJob($defineNo, $jobName);
                // $start=$item->sch_start;
                // $start=date_create($start);
                if ($item!=null) {
                    // var_dump($item->sch_start);
                    // var_dump(date('Y-m-d'));
                    $start=$item->sch_start;
                    $date=date_create($start);
                    $start=date_format($date, 'Y-m-d');
                    if ($item->sch_status == self::STATUS_SUCCESS && $start==date('Y-m-d')) {
                        continue;
                    }
                    else 
                    {
                        $scheduleJob=new ScheduleJob();
                        $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                    } 
                } 
                else 
                {
                    $scheduleJob=new ScheduleJob();
                    $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                } 

                $item->sch_status = self::STATUS_EXCUTE;
                $item->sch_start=date("Y-m-d h:i:s");
                $item->save();
                try
                {
                    $item->sch_status = self::STATUS_EXCUTE;
                    $item->save();  
                    $jobClass = $define->sch_jobclass;
                    $jobObj = new $jobClass();
            
                    $jobObj->run();
                    $item->sch_status = self::STATUS_SUCCESS;
                    $item->save();  
                    //  $define->sch_lastjob=date("Y-m-d h:i:s");
                    $item->sch_end=date("Y-m-d h:i:s");
                } 
                catch (QueryException $e) 
                {
                    Log::info($e);
                    $item->sch_status = self::STATUS_FAIL;
                    $item->save();  
                    continue;
                }

                $define->save();
                $item->save();
            }
        }
    } 

    public function getSusccessStatus()
    {
        $model=$this->newitem();
        $result=$model->orderBy('created_at', 'desc')
            ->where('sch_success', self::STATUS_SUCCESS)
            ->first();
        return $result;
    }  

    public function getLastStatus($jobNo)
    {
        $model=$this->newitem();
        $result=$model->where('sch_jobno', $jobNo)
            ->first();
        return $result;
    }

    public function createHourlyJob()
    {
        
        $scheduleDefineData=new ScheduleDefineData();
        $scheduleDefine=$scheduleDefineData->getScheduleDefine();
        $time=time();

        foreach($scheduleDefine as $define){
            // dump($define->sch_name);
            if($define->sch_type==self::SCHEDULE_HOUR) {
                $defineType=$define->sch_type;
                $defineNo=$define->sch_no;
                $jobName = $this->createJobItemName($define);
                $item = $this->getJob($defineNo, $jobName);
                
                if ($item!=null) {
                    $start=$item->sch_start;
                    $date=date_create($start);
                    $start=date_format($date, 'Y-m-d H:00:00');
                    if ($item->sch_status == self::STATUS_SUCCESS && strtotime($start)==strtotime(date('Y-m-d H:00:00'))) {
                        continue;
                    }
                    else
                    {
                        $scheduleJob=new ScheduleJob();
                        $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                    }
                } 
                else 
                {
                    $scheduleJob=new ScheduleJob();
                    $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                } 

                $item->sch_status = self::STATUS_EXCUTE;
                $item->sch_start=date("Y-m-d h:i:s");
                $item->save();
                $methods = ["hourlyrun","hourrun","run"];
                try
                {
                    $item->sch_status = self::STATUS_EXCUTE;
                    $item->save();  
                    $jobClass = $define->sch_jobclass;
                    $jobObj = new $jobClass();
                    $jobObj->hourrun();
                    $item->sch_status = self::STATUS_SUCCESS;
                    $item->save();  
                    $item->sch_end=date("Y-m-d h:i:s");
                } 
                catch (QueryException $e) 
                {
                    Log::info($e);
                    $item->sch_status = ScheduleDefineData::STATUS_FAIL;
                    $item->save();  
                    continue;
                }

                $define->save();
                $item->save();
            }
        }
    } 

    public function createMonthJob()
    {
        
        $scheduleDefineData=new ScheduleDefineData();
        $scheduleDefine=$scheduleDefineData->getScheduleDefine();
        $time=time();
        // dump($time);
        foreach($scheduleDefine as $define){
            // dump($define->sch_name);
            if($define->sch_type==self::SCHEDULE_MONTH) {

                $defineType=$define->sch_type;
                $defineNo=$define->sch_no;
                $jobName = $this->createJobItemName($define);
                $item = $this->getJob($defineNo, $jobName);
                // $start=$item->sch_start;
                // $start=date_create($start);
                if ($item!=null) {
                    // var_dump($item->sch_start);
                    // var_dump(date('Y-m-d'));
                    $start=$item->sch_start;
                    $date=date_create($start);
                    $start=date_format($date, 'Y-m');
                    if ($item->sch_status == self::STATUS_SUCCESS && $start==date('Y-m')) {
                        continue;
                    }
                    else 
                    {
                        $scheduleJob=new ScheduleJob();
                        $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                    } 
                } 
                else 
                {
                    $scheduleJob=new ScheduleJob();
                    $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                } 

                $item->sch_status = self::STATUS_EXCUTE;
                $item->sch_start=date("Y-m-d h:i:s");
                $item->save();
                try
                {
                    $item->sch_status = self::STATUS_EXCUTE;
                    $item->save();  
                    $jobClass = $define->sch_jobclass;
                    $jobObj = new $jobClass();
            
                    $jobObj->run();
                    $item->sch_status = self::STATUS_SUCCESS;
                    $item->save();  
                    //  $define->sch_lastjob=date("Y-m-d h:i:s");
                    $item->sch_end=date("Y-m-d h:i:s");
                } 
                catch (QueryException $e) 
                {
                    Log::info($e);
                    $item->sch_status = ScheduleDefineData::STATUS_FAIL;
                    $item->save();  
                    continue;
                }

                $define->save();
                $item->save();
            }
        }
    } 

    /**
     * 按周处理事务
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function createWeeklyJob()
    {
        
        $scheduleDefineData=new ScheduleDefineData();
        $scheduleDefine=$scheduleDefineData->getScheduleDefine();
        $time=time();
        // dump($time);
        foreach($scheduleDefine as $define){
            // dump($define->sch_name);
            if($define->sch_type==self::SCHEDULE_WEEK) {

                $defineType=$define->sch_type;
                $defineNo=$define->sch_no;
                $jobName = $this->createJobItemName($define);
                $item = $this->getJob($defineNo, $jobName);
                // $start=$item->sch_start;
                // $start=date_create($start);
                if ($item!=null) {
                    // var_dump($item->sch_start);
                    // var_dump(date('Y-m-d'));
                    $start=$item->sch_start;
                    $date=date_create($start);
                    $start=date_format($date, 'Y-W');
                    if ($item->sch_status == self::STATUS_SUCCESS && $start==date('Y-W')) {
                        continue;
                    }
                    else 
                    {
                        $scheduleJob=new ScheduleJob();
                        $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                    } 
                } 
                else 
                {
                    $scheduleJob=new ScheduleJob();
                    $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                } 

                $item->sch_status = self::STATUS_EXCUTE;
                $item->sch_start=date("Y-m-d h:i:s");
                $item->save();
                try
                {
                    $item->sch_status = self::STATUS_EXCUTE;
                    $item->save();  
                    $jobClass = $define->sch_jobclass;
                    $jobObj = new $jobClass();
            
                    $jobObj->weekrun();
                    $item->sch_status = self::STATUS_SUCCESS;
                    $item->save();  
                    //  $define->sch_lastjob=date("Y-m-d h:i:s");
                    $item->sch_end=date("Y-m-d h:i:s");
                } 
                catch (QueryException $e) 
                {
                    Log::info($e);
                    $item->sch_status = ScheduleDefineData::STATUS_FAIL;
                    $item->save();  
                    continue;
                }

                $define->save();
                $item->save();
            }
        }
    } 

    /**
     * 按分钟处理事务
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function createMinutelyJob()
    {
        
        $scheduleDefineData=new ScheduleDefineData();
        $scheduleDefine=$scheduleDefineData->getScheduleDefine();
        $time=time();
        // dump($time);
        foreach($scheduleDefine as $define){
            // dump($define->sch_name);
            if($define->sch_type==self::SCHEDULE_MINUTE) {

                $defineType=$define->sch_type;
                $defineNo=$define->sch_no;
                $jobName = $this->createJobItemName($define);
                $item = $this->getJob($defineNo, $jobName);
                // $start=$item->sch_start;
                // $start=date_create($start);
                if ($item!=null) {
                    // var_dump($item->sch_start);
                    // var_dump(date('Y-m-d'));
                    $start=$item->sch_start;
                    $date=date_create($start);
                    $start=date_format($date, 'Y-m-d H:i:00');
                    if ($item->sch_status == self::STATUS_SUCCESS && $start==date('Y-m-d H:i:00')) {
                        continue;
                    }
                    else 
                    {
                        $scheduleJob=new ScheduleJob();
                        $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                    } 
                } 
                else 
                {
                    $scheduleJob=new ScheduleJob();
                    $item=$scheduleJob->createJobItem($define, ScheduleJob::TYPE_SCHECULE, $jobName);
                } 

                $item->sch_status = self::STATUS_EXCUTE;
                $item->sch_start=date("Y-m-d h:i:s");
                $item->save();
                try
                {
                    $item->sch_status = self::STATUS_EXCUTE;
                    $item->save();  
                    $jobClass = $define->sch_jobclass;
                    $jobObj = new $jobClass();
            
                    $jobObj->minuterun();
                    $item->sch_status = self::STATUS_SUCCESS;
                    $item->save();  
                    //  $define->sch_lastjob=date("Y-m-d h:i:s");
                    $item->sch_end=date("Y-m-d h:i:s");
                } 
                catch (QueryException $e) 
                {
                    Log::info($e);
                    $item->sch_status = ScheduleDefineData::STATUS_FAIL;
                    $item->save();  
                    continue;
                }

                $define->save();
                $item->save();
            }
        }
    } 
}

