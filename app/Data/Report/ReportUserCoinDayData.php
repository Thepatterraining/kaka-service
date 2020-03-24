<?php

namespace App\Data\Report;

use App\Data\Sys\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Sys\LockData;
use App\Data\Transaction\TransactionData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Schedule\IDaySchedule;
use App\Data\User\CoinAccountData;
use App\Data\Report\ReportUserCoinItemDayData;

class ReportUserCoinDayData extends IReportUserCoinDayData implements IDaySchedule
{

    /**
     * 用户查询邀请状态信息
     *
     * @param   pageSize 数量
     * @param   pageIndex 页码
     * @author  liu
     * @version 0.1
     */

    protected $userAdapter = "App\Http\Adapter\Sys\UserAdapter";
    protected $userData = "App\Data\Sys\UserData";
    protected $reportAdapter = "App\Http\Adapter\Report\ReportUserCoinDayAdapter";
    protected $reportData="App\Data\Report\ReportUserCoinDayData";
    protected $modelclass = "App\Model\Report\ReportUserCoinDay";
    protected $rechargeData="App\Data\Cash\RechargeData";
    protected $tranactionData="App\Data\Trade\TranactionOrderData";
    protected $invitationData="App\Data\Activity\InvitationData";
    protected $rakeBackTypeData="App\Data\Sys\RakebackTypeData";
    protected $rabateData="App\Data\Sys\RebateData";
    protected $withdrawalData="App\Data\Cash\WithdrawalData";
    protected $voucherStorageData="App\Data\Activity\VoucherStorageData";
    protected $voucherInfoData="App\Data\Activity\VoucherInfoData";
    protected $userCashJournalData="App\Data\User\CashJournalData";
    protected $coinAccountData="App\Data\User\CoinAccountData";

    /**
     * 获得上一条报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */   
    public function getLastReport($userId)
    {
        $model=$this->newitem();
        $rep=$model->orderBy('report_end', 'desc')->where('report_user', $userId)->first();
        return $rep;
    }
    /**
     * 获得上一条报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */   
    public function getLastReportCommon($userId)
    {
        $model=$this->newitem();
        $rep=$model->orderBy('report_end', 'desc')->where('report_user', $userId)->first();
        return $rep;
    }
    /**
     * 生成所有报表
     */ 
    public function makeAllDayReport()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                $this->makeDayReport($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    /**
     * 获得用户上一天报表
     *
     * @param $userId 用户id
     */ 
    public function getResultReportDaily($userId)
    {
        $model=$this->newitem();
        $date=date_create(date("Y-m-d 0:00:00"));
        $date=date_add($date, date_interval_create_from_date_string("-1 days"));
        $result=$model->where('report_user', $userId)
            ->where('report_start', $date)
            ->first();
        return $result;
    }
    /**
     * 获得用户大前天报表
     *
     * @param $userId 用户id
     */ 
    public function getResultReportLastDaily($userId)
    {
        $model=$this->newitem();
        $date=date_create(date("Y-m-d 0:00:00"));
        $date=date_add($date, date_interval_create_from_date_string("-2 days"));
        $result=$model->where('report_user', $userId)
            ->where('report_start', $date)
            ->first();
        return $result;
    }
        /**
         * 获得用户上个月报表
         *
         * @param $userId 用户id
         */ 
    public function getResultReportMonthly($userId)
    {
        $model=$this->newitem();
        $topDate=date_create(date("Y-m-1 0:00:00"));
        $date=date_create(date("Y-m-d 0:00:00"));
        $lastDate=date_add($date, date_interval_create_from_date_string("-1 days"));
        $result=$model->where('report_user', $userId)
            ->wherebetween('report_start', [$topDate,$lastDate])
            ->get();
        return $result;
    }

    /**
     * 获得上个周期（月）报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */ 
    public function getResultReportLastMonth($userId)
    {
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $qur=$model//->orderBy('report_start','desc')
        ->where('report_user', $userId)
        //->where('report_start',$date)
        ->where('report_rbbuy_ispay', 1)
        ->max('report_start');
        $result=$model->where('report_user', $userId)
            ->where('report_start', $qur)
            ->first();
        return $result;
    }

    /**
     * 获得上一条已审核报表
     *
     * @param $userId 用户id
     */ 
    public function getResult($userId)
    {
        $model=$this->newitem();
        $result=$model->where('report_user', $userId)
            ->where('report_rbbuy_ispay', 1)->get();
                    return $result;
    }

    /**
     * 获得上一条报表单号
     *
     * @param $userId 用户id
     * @param $date  指定日期
     */ 
    public function getReportNo($userId,$date)
    {
        $model=$this->newitem();
        $result=$model->where('report_user', $userId)
            ->where('report_start', $date)
            ->first();
        return $report->report_no;

    }

    /**
     * 获得上一条报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */
    public function getByNo($no)
    {
        $model=$this->newitem();
        $result = $model->where('report_no', $no)->first();
        return $result;
    } 

         /**
          * 获得上个周期（月）报表
          *
          * @param $start  起始时间
          */ 
    public function getTop($date,$loop)
    {
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $result=$model//->orderBy('report_rbbuy_result','desc')
        ->where('report_end', $date)
        //->where('report_rbbuy_ispay',1)
        ->skip($loop-1)
        ->take(1)
        ->first();

        return $result;
    }
    /*
     * 获得返佣总数报表
     * @param $date  起始时间
     * 
     */ 
    public function getAllTop($date)
    {
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $result=$model->orderBy('report_rbbuy_result', 'desc')
            ->where('report_start', $date)
        //->whereNull('report_rbbuy_chkuser')
        //->where('report_rbbuy_ispay',1)
            ->select('report_user', 'report_rbbuy_result')
            ->get();

        return $result;
    }

    /*
     * 获得未审核返佣总数报表
     * @param $date  起始时间
     * 
     */ 
    public function getAllUncheckTop($date)
    {
        $motiDate=date_format($date, ("Y-m-d 0:00:00"));
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $result=$model->orderBy('report_rbbuy_result', 'desc')
            ->where('report_start', $motiDate)
            ->whereNull('report_rbbuy_chkuser')
        //->where('report_rbbuy_ispay',1)
            ->select('report_user', 'report_rbbuy_result')
            ->get();

        return $result;
    }

    public function run()
    {

        //return 1;
        $userFac = new UserData();
        $coinAccountData=new CoinAccountData();
        $reportUserCoinItemData=new ReportUserCoinItemDayData();
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
        $info=$this->getTop(date_format($endDate, "Y-m-d"), $idCount);

        // 若取不到日报排行，则取日报最新排行
        while(empty($info))
        {
            date_add($endDate, date_interval_create_from_date_string("-1 days"));
            $idCount=$userFac->getMaxIdDay($endDate);
            $info=$this->getTop(date_format($date, "Y-m-d"), $idCount);
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
            $pageSize = 100;
            $pageIndex = 1;
            $filter=[
                "created_at"=>['<=',$tmp_end]
            ];
            $result = $userFac->query($filter, $pageSize, $pageIndex);
            while($pageIndex<=($result["pageCount"])){  
                foreach($result["items"] as $resultitem){
                    $res=$this->makeDayReport($resultitem->id, $tmp_start, $tmp_end);
                }
                $pageIndex ++;
                $result = $userFac->query($filter, $pageSize, $pageIndex);   
            }
            // $this->makeReport($tmp_start, $tmp_end, $this::$DAY);

            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }

        return true;
    }
    
    public function getReportByNo($no)
    {
        $model=$this->newitem();
        $result=$model->where('report_no', $no)->first();
        return $result;
    }   

    public function getById($id,$start)
    {
        $time=strtotime($start);
        $time=date("Y-m-d", $time);
        $model=$this->newitem();
        $result=$model->where('report_user', $id)
            ->where('report_start', $time)
            ->first();
        return $result;      
    }

    public function getDailyReport($start,$end)
    {
        $model=$this->newitem();
        $result=$model->where('report_start', $start)
            ->where('report_end', $end)
            ->get();
        return $result;
    }
}
