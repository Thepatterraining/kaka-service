<?php
namespace App\Data\Schedule;
use App\Adapter\Schedule\ScheduleDefineAdapter;
use App\Data\IDataFactory;

class ScheduleDefineData extends IDataFactory
{

    protected $modelclass = 'App\Model\Schedule\ScheduleDefine';

    public function getScheduleDefine()
    {
        $item = $this->newitem();
        return $item->all();
    }

    public function createScheduleDefine($schName,$path,$name,$schType)
    {
        $item = $this->newitem();
        //$item->sch_no = DocNoMaker::Generate($no);
        $item->sch_no=$name;
        //$item->item_success = 0;
        $item->sch_name=$schName;
        $item->sch_namestr=$schName;
        $item->sch_type=$schType;
        $item->sch_jobclass="\App\Data".$path;//path格式需要在行首加’\‘字符
        $this->create($item);
        return $item;
    }

    public function updateScheduleDefine($schName,$path)
    {
        $model = $this->newitem();
        $item=$model->where('schName', $schNname)->first();
        $item->sch_no = "SCH".strtotime("-1 Day");//DocNoMaker::Generate("SCH");
        //$item->item_success = 0;
        $item->sch_jobclass="\App\Data".$path;//path格式需要在行首加’\‘字符
        $item->save();
        return $item;
    }

    public function deleteScheduleDefine($schNo)
    {
        $item=$this->newitem();
        $item->where('sch_no', $schNo)->delete();
    }

    public function getSingleScheduleDefine($schName)
    {
        $item=$this->newitem();
        $result=$item->where('sch_name', $schName)->first();
        return $result;
    }

    public function getSingleScheduleDefineBySchNo($schNo)
    {
        $item=$this->newitem();
        $result=$item->where('sch_no', $schNo)->first();
        return $result;
    }
}