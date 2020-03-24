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
use App\Data\Schedule\IDaySchedule;

class ReportRechargeItemDayData extends IReportRechargeItemDayData implements IDaySchedule
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
    protected $reportAdapter = "App\Http\Adapter\Report\ReportUserRechargeItemDayAdapter";
    // protected $noPre = "SCR";
    protected $reportData="App\Data\Report\ReportRechargeDayData";
    protected $modelclass = "App\Model\Report\ReportRechargeItemDay";
    protected $rechargeData="App\Data\Cash\RechargeData";
    protected $payChannelData="App\Data\Payment\PayChannelData";

    /**
     * 获得上一条报表
     *
     * @param $no 报表编号
     * @param $start  起始时间
     */   
    public function getLastReport($rechargeType)
    {
        $reportRechargeDayData=new ReportRechargeDayData();
        $info=$reportRechargeDayData->newitem();
        $tmp=$info->orderBy('report_end', 'desc')->skip(1)->first();
        // dump($tmp);
        if(!empty($tmp)) {
            $model=$this->newitem();
            $rep=$model->where('report_no', $tmp->report_no)->where('report_recharge_channel_id', $rechargeType)->first();
        }
        else {
            $rep=null;
        }
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
        $result=$model->orderBy('report_rbbuy_result', 'desc')
            ->where('report_start', $date)
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
}
