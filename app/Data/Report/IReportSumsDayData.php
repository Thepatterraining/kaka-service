<?php
namespace App\Data\Report;

use App\Data\IDataFactory;
use App\Data\Sys\UserData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;
use App\Data\Report\ReportSumsDayData;

abstract class IReportSumsDayData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $userAdapter = "";
    protected $userData = "";
    protected $reportAdapter = "";
    protected $noPre = "";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Report\ReportSumsDay';

    abstract protected function maxIdByTime();
    
    //2017.8.17 调整报表参数 liu
    //去掉redis锁 2017.9.5 liu
    public function makeReport($start, $end, $reportType)
    {
                        
        $lockKey = get_class($this)."start".$start."end".$end;
        // $lk = new LockData();
             
        
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $userData = new $this->userData();//UserData();
        $userAdapter = new $this->userAdapter();
        $reportAdapter = new $this->reportAdapter();
        
        
        $reportfilter =[
            "filters"=>[
            "begin"=>['=',$startd],
            "end"=>['=',$endd]
            ]
        ];
        
        $queryfilter = $reportAdapter->getFilers($reportfilter);
        // 
        //($queryfilter);
        $items = $this->query($queryfilter, 1, 1);
        //dump($items["totalSize"]);
        if ($items["totalSize"]>0) {
            return ;
        }
        // if ($lk->lock($lockKey)===false) {
        //     return ;
        // }
        $rptModel = $this->newitem();
        $rpt = array();
        $rpt["runtype"] = $reportType;
        
        //$rpt["no"] = DocNoMaker::Generate($this->noPre);
        $rpt ["begin"] = $startd;
        $rpt["end"] = $endd;
        //$rpt["accountid"] = $accountid;
        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->create($rptModel);
        
        $rpt = $reportAdapter->getDataContract($rptModel, null, true);
        
        $lastResult = $this->maxIdByTime();
        if(!empty($lastResult)) {
            $intcount=$lastResult['report_currentcount'];
            $lastlogin=$lastResult['report_currentlogin'];
            $rpt['start']=$lastResult->report_end;
            $start=$lastResult->report_end;
        }
        else
        {
            $intcount=0;
            $lastlogin=0;
        }

        $querycreatefilter = [
        "filters"=>[
            "created_at"=>[
                $start,
                $end
            ]
        ]
        ];
        $queryloginfilter = [
        "filters"=>[
            "user_lastlogin"=>[
                $start,
                $end
            ]
        ]
        ];
        $createfilter = $userAdapter->getFilers($querycreatefilter);
        $loginfilter = $userAdapter->getFilers($queryloginfilter);

        $pageIndex = 1;
        $pageSize = 100;
        
        $itemIndex=0;
             
        $createResult = $userData->userquery("created_at", $querycreatefilter, $pageSize, $pageIndex);
        $loginResult = $userData->userquery("user_lastlogin", $queryloginfilter, $pageSize, $pageIndex);

        $rpt["name"]=date("Y", strtotime($start))."年".date("m", strtotime($start))."月".date("d", strtotime($start))."日报表";//"from" + $startd + "to" + $endd;
        $rpt["type"]=$reportType;

        if(empty($createResult)) {
            return ErrorData::$USER_NOT_FOUND;
        }

        else
        {
            $currentCount=$createResult['totalSize'];
            $currentlogin=$loginResult['totalSize'];
        }   

        $rpt["intcount"]=$userData->newitem()->where('created_at', '<=', $start)->count();
        $rpt["acscount"]=$currentCount;
        $rpt["currentcount"]=$currentCount+$rpt["intcount"];
        $rpt["lastlogin"]=$lastlogin;
        $rpt["acslogin"]=$currentlogin-$lastlogin;
        $rpt["currentlogin"]=$currentlogin;
        $rpt["start"]=$start;
        $rpt["end"]=$end;

        $reportAdapter->saveToModel(false, $rpt, $rptModel);
        $this->save($rptModel);
        // $lk->unlock($lockKey);
        return $rpt;
    }
    
    
    public function makeDayReport()
    {
        
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        // date_add($start, date_interval_create_from_date_string("-1 days"));
        // $start = date_format($start, 'Y-m-d H:i:s');
        $reportSumsDayData=new ReportSumsDayData();
        $start=$reportSumsDayData->getLastReportCommon()->report_end;
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        
        while(strtotime($tmp_end)<=strtotime($end))
        {
            dump($tmp_end);
            $this->makeReport($tmp_start, $tmp_end, $this::$DAY);
            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }
        return true;
        // return $this->makeReport($start, $end, $this::$DAY);
    }

}
