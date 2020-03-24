<?php
namespace App\Data\Schedule;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class ScheduleJob extends IDataFactory
{

    protected $modelclass = 'App\Model\Schedule\ScheduleItem';

      const TYPE_SCHECULE="SCH02";

      const STATUS_INIT = "JST01";
      const STATUS_EXCUTE="JST02";
      const STATUS_SUCCESS = "JST03"; 
      const STATUS_FAIL = "JST04";
      const STATUS_SEND = "JST05";
      const STATUS_SEND_FAIL = "JST06";

    public function createJobItem($scheduleDefine,$type = ScheduleJob::TYPE_SCHECULE,$jobName)
    {
        $item = $this->newitem();
        $item->sch_itemno =DocNoMaker::Generate("SCHJ");// $jobName;
        //$item->item_success = 0;
        $item->sch_itemname=$scheduleDefine->sch_name;
        $item->sch_jobno=null;
        $item->sch_status=ScheduleJob::STATUS_INIT;
        $item->sch_defno=$scheduleDefine->sch_no;
        $item->sch_itemname = $jobName;
        $this->create($item);
        return $item;
    }


    public function addReportJob($url,$query)
    {
        $item = $this->newitem();
        $item->sch_itemno =  DocNoMaker::Generate("SCHI");
        $item->sch_param = $query;
        $item->sch_dealclass = $url;
        $item->sch_defno="";    
        $item->sch_status =  ScheduleJob::STATUS_INIT;
        $item->sch_itemname = "用户自定义报表";
        $this->create($item);
        return $item->sch_itemno;

    }

    public function getUserExcelJob($callback,...$param)
    {
    
        $this->queryAllWithoutPageturn(
            [
                "sch_defno"=>['=',""],
                "sch_status"=>["=", ScheduleJob::STATUS_INIT],
                "sch_itemname"=>["=","用户自定义报表"]

            ], $callback, ...$param
        );
    }

    public function saveReportJob($data)
    {
        $item = $this->get($data['id']);

        $item->sch_itemno =  $data['sch_itemno'];
        // $item->sch_param = json_encode($data['sch_param']);
        $item->sch_dealclass = $data['sch_dealclass'];
        $item->sch_defno = $data['sch_defno'];
        $item->sch_status =  $data['sch_status'];
        $item->sch_itemname = $data['sch_itemname'];
        return $this->save($item);
    }
}

