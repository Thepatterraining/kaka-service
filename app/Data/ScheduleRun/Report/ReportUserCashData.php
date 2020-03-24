<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportUserCashDayData;
use App\Data\Sys\UserData;

class ReportUserCashData implements IDaySchedule
{
    //
    public function run()
    {
        $userFac = new UserData();
        $reportUserCashData=new ReportUserCashDayData();

        $end=date("Y-m-d");
        $start=date_create($end);
        $date=date_create($end);
        $lastDate=date_create($end);
        $endDate=date_create($end);

        //时间初始化

        date_add($start, date_interval_create_from_date_string("-1 days"));
        //$start=date_format($start,"Y-m-d 0:00:00");
        date_add($date, date_interval_create_from_date_string("-1 days"));
        date_add($lastDate, date_interval_create_from_date_string("-2 days"));
        $existDate=date_format($date, "Y-m-d");
        $idCount=$userFac->getMaxIdDay($endDate);
        $info=$reportUserCashData->getTop(date_format($endDate, "Y-m-d"), $idCount);
        // dump($info);
        // 若取不到日报排行，则取日报最新排行
        while(empty($info))
        {
            date_add($endDate, date_interval_create_from_date_string("-1 days"));
            $idCount=$userFac->getMaxIdDay($endDate);
            $info=$reportUserCashData->getTop(date_format($date, "Y-m-d"), $idCount);
            date_add($date, date_interval_create_from_date_string("-1 days"));
            // var_dump(date_format($date,"Y-m-d"));
            if(date_format($date, "Y-m-d")=="2017-04-05") {
                break;
            }
        } 
        // dump($date);
        $tmpDate=$date;
        date_add($tmpDate, date_interval_create_from_date_string("1 days"));
        // dump($existDate);
        // dump($tmpDate);
        if($existDate!=$tmpDate) {
            $start=$tmpDate;
        }
        // dump($start);
        if(is_object($start)) {
            $start=date_format($start, "Y-m-d");
        }
        // dump($start);
        // dump($end);
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        
        while(strtotime($tmp_end)<=strtotime($end))
        {
            // dump($tmp_end);
            $pageSize = 100;
            $pageIndex = 1;
            $filter=[
                "created_at"=>['<=',$tmp_end]
            ];
            $result = $userFac->query($filter, $pageSize, $pageIndex);
            while($pageIndex<=($result["pageCount"])){  
                foreach($result["items"] as $resultitem){
                    $reportUserCashData->makeDayReport($resultitem->id, $tmp_start, $tmp_end);
                }
                $pageIndex ++;
                $result = $userFac->query($filter, $pageSize, $pageIndex);   
            }

            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");

        }   
        return true;
    }
}