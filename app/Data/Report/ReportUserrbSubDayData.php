<?php

namespace App\Data\Report;

use App\Data\Sys\UserData;
use App\Http\Adapter\User\UserAdapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Sys\LockData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Schedule\IDaySchedule;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\Formater;

class ReportUserrbSubDayData extends IReportUserrbSubDayData implements IDaySchedule
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
    protected $reportAdapter = "App\Http\Adapter\Report\ReportUserrbSubDayAdapter";
    // protected $noPre = "SCR";
    protected $reportData="App\Data\Report\ReportUserrbSubDayData";
    protected $modelclass = "App\Model\Report\ReportUserrbSubDay";
    protected $rechargeData="App\Data\Cash\RechargeData";
    protected $tranactionData="App\Data\Trade\TranactionOrderData";
    protected $invitationData="App\Data\Activity\InvitationData";
    protected $rakeBackTypeData="App\Data\Sys\RakebackTypeData";
    protected $rebateData="App\Data\Sys\RebateData";

    protected $no = 'report_no';


    /**
     * 获得上一条报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */   
    public function getLastReport($userId,$start)
    {
        $model=$this->newitem();
        $rep=$model->where('report_end', $start)->where('report_user', $userId)->first();
        return $rep;
    }
    /**
     * 获得最近上一条报表
     *
     * @param $userId 用户id
     * @param $start  起始时间
     */   
    public function getLastReportDesc($userId)
    {
        $model=$this->newitem();
        $rep=$model->where('report_user', $userId)->orderBy('report_end', 'desc')->first();
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
        //$date=date_add($date, date_interval_create_from_date_string("-1 days"));
        $result=$model->where('report_user', $userId)
            ->orderBy('report_start', 'desc')
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
        $date=date_add($date, date_interval_create_from_date_string("-1 days"));
        $result=$model->where('report_user', $userId)
            ->where('report_end', $date)
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
        //$lastDate=date_add($date, date_interval_create_from_date_string("-1 days"));
        $result=$model->where('report_user', $userId)
            ->wherebetween('report_end', [$topDate,$date])
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
          * @param $date  起始时间
          * @param $loop 预计排名
          */ 
    public function getTop($date,$loop)
    {
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $result=//DB::select("select * from report_userrb_sub_day where `report_end`=? group by `report_user` order by `report_rbbuy_totalresult` DESC LIMIT ?,1",[$date,$loop-1]);
        $model//->orderBy('report_end','desc')
        ->orderBy('report_rbbuy_result', 'desc')
        ->where('report_end', $date)
        ->skip($loop-1)
        ->take(1)
        ->first();

        return $result;
    }

    /*
     * 获得上个周期（月）报表
     * @param $date  起始时间
     * @param $loop 预计排名
     * 
     */ 
    public function getLow($date,$loop)
    {
        $model=$this->newitem();
        //$date=mktime(0,0,0,date('m'),-1,date('Y'));

        //$date=date_create();
        $result=$model->orderBy('report_rbbuy_result', 'desc')
            ->where('report_end', $date)
        //->where('report_rbbuy_ispay',1)
            ->count();

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

    public function getUserInvitationAmount()
    {
        $userId=$this->session->userid;
        $report=$this->getResultReportDaily($userId);
        $result=$this->getResult($userId);
        $count=0;
        foreach($result as $value)
        {
            $count=$count+$value->report_rbbuy_result;
        }
        $init=$report->report_rbbuy_result;
        if($report->report_rbbuy_chkuser!=null) {
            $count=$count-$init;
        }
        $totalMoney=floor(($count+$init) * 100) / 100;
        return $totalMoney;
    }

    public function run()
    {

        //return 1;
        $userFac = new UserData();
        $invitationData=new InvitationData();
        $tranactionData=new TranactionOrderData();
        $tranactionBuyData=new TranactionBuyData();
        $rechargeData=new RechargeData();
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
 
        $tmpDate=$date;
        date_add($tmpDate, date_interval_create_from_date_string("1 days"));
       
        if($existDate!=$tmpDate) {
            $start=$tmpDate;
        }
        
        if(is_object($start)) {
            $start=date_format($start, "Y-m-d");
        }
       
        $tmp_start=$start;
        $tmp_end=date_create($tmp_start);
        date_add($tmp_end, date_interval_create_from_date_string("1 days"));
        $tmp_end=date_format($tmp_end, "Y-m-d");
        while(strtotime($tmp_end)<=strtotime($end))
        {
            //初始化
            
            $userInfo=$userFac->getAllId($tmp_end);
            foreach($userInfo as $value)
            {
                $sts[$value->id]["recharge"]=0;
                $sts[$value->id]["rbrecharge"]=0;
                $sts[$value->id]["buy"]=0;
                $sts[$value->id]["rbbuyascinv"]=0;
                $sts[$value->id]["rbbuy"]=0;
            }
            //区间返佣数据处理
            $rechargeResult=$invitationData->getTotalRecharge($tmp_start, $tmp_end);
            // dump($rechargeResult);
            if(!empty($rechargeResult)) {
                foreach($rechargeResult as $reResult) {
                    $sts[$reResult->inviitation_user]["rbrecharge"]=$reResult->cash;
                }
            }

            $buyResult=$invitationData->getTotalBuy($tmp_start, $tmp_end);
            if(!empty($buyResult)) {
                foreach($buyResult as $bResult)
                {
                    $sts[$bResult->inviitation_user]["rbbuy"]=$bResult->cash;
                    $sts[$bResult->inviitation_user]["rbbuyascinv"]=$bResult->amount;    
                }
            }

            $recharge=$rechargeData->getRechargeDaily($tmp_start, $tmp_end);
            // dump($recharge);
            if(!$recharge->isEmpty()) {
                foreach($recharge as $rechargeItem)
                {
                    $sts[$rechargeItem->cash_recharge_userid]["recharge"]+=floor($rechargeItem->cash_recharge_amount * 100)/100;
                }
            }

            $trade=$tranactionData->getTradeDaily($tmp_start, $tmp_end);
            if(!$trade->isEmpty()) {
                foreach($trade as $tradeItem)
                {
                    //判断是否为一级市场
                    $tradeType=$tranactionBuyData->getLevelType($tradeItem->order_buy_no);
                    if($tradeType=='BL01') {
                        $sts[$tradeItem->order_buy_userid]["buy"]+=floor($tradeItem->order_amount * 100)/100;
                    }
                }
            }
            // $this->makeDayReport(1,$sts[1],$start,$end);
            $pageSize = 100;
            $pageIndex = 1;
            $filter=[
                "created_at"=>['<=',$tmp_end]
            ];
            $result = $userFac->query($filter, $pageSize, $pageIndex);
            $i=0;
            while($pageIndex<=($result["pageCount"])){   
                foreach($result["items"] as $resultitem){
                    //dump($resultitem->id);
                    $i++;
                    $this->makeDayReport($resultitem->id, $sts[$resultitem->id], date_create($tmp_start), $tmp_end);
                }
                $pageIndex ++;
                $result = $userFac->query([], $pageSize, $pageIndex);   
            }
            $next_start=date_create($tmp_start);
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_start=date_format($next_start, "Y-m-d");
            date_add($next_start, date_interval_create_from_date_string("1 days"));
            $tmp_end=date_format($next_start, "Y-m-d");
        }
        return true;
    }

    public function getReport($userId,$userCreatedTime)
    {
        $model=$this->newitem();
        $result=$model->where('report_user', $userId)->orderBy('report_start', 'desc')->take(1);//v$userCreatedTimve)->first();
        return $result;
    }

    public function getRebuyDaily($userId)
    {
        $model=$this->newitem();
        $result=$model->orderBy('report_start', 'desc')->where('report_user', $userId)->sum('report_rbbuy_asc');
        // $i=0;
        // while((empty($result)))
        // {
        //     // dump($i);
        //     $i++;
        //     $result=$model->orderBy('report_start','desc')->where('report_user',$userId)->skip($i)->first();
        //     if($i==31)
        //     {
        //         $result->report_rbbuy_totalresult=0;
        //         break;
        //     }            
        // }
        if(($result==null)) {
            $result=intval("0.000");
        }
        else
        {   
            // $result=intval(floatval($result) * 100) / 100;
            $result=Formater::ceil($result, 2);
        }
        
        return $result;
    }

    public function allrun()
    {

        //return 1;
        $userFac = new UserData();
        $invitationData=new InvitationData();
        $tranactionData=new TranactionOrderData();
        $rechargeData=new RechargeData();
        $end=date("Y-m-d");
        $start=date_create($end);
        $date=date_create($end);
        $lastDate=date_create($end);
        $endDate=date_create($end);

        //初始化
        $userInfo=$userFac->getAllId($end);
        foreach($userInfo as $value)
        {
            $sts[$value->id]["recharge"]=0;
            $sts[$value->id]["rbrecharge"]=0;
            $sts[$value->id]["buy"]=0;
            $sts[$value->id]["rbbuyascinv"]=0;
            $sts[$value->id]["rbbuy"]=0;
        }
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
        //区间返佣数据处理
        $rechargeResult=$invitationData->getTotalRecharge($start, $end);
        // dump($rechargeResult);
        if(!empty($rechargeResult)) {
            foreach($rechargeResult as $reResult) {
                $sts[$reResult->inviitation_user]["rbrecharge"]=$reResult->cash;
            }
        }

        $buyResult=$invitationData->getTotalBuy($start, $end);
        if(!empty($buyResult)) {
            foreach($buyResult as $bResult)
            {
                $sts[$bResult->inviitation_user]["rbbuy"]=$bResult->cash;
                $sts[$bResult->inviitation_user]["rbbuyascinv"]=$bResult->amount;    
            }
        }

        $recharge=$rechargeData->getRechargeDaily($start, $end);
        // dump($recharge);
        if(!$recharge->isEmpty()) {
            foreach($recharge as $rechargeItem)
            {
                $sts[$rechargeItem->cash_recharge_userid]["recharge"]+=floor($rechargeItem->cash_recharge_amount * 100)/100;
            }
        }

        $trade=$tranactionData->getTradeDaily($start, $end);
        if(!$trade->isEmpty()) {
            foreach($trade as $tradeItem)
            {
                $sts[$tradeItem->order_buy_userid]["buy"]+=floor($tradeItem->order_amount * 100)/100;
            }
        }
        // $this->makeDayReport(1,$sts[1],$start,$end);
        $pageSize = 100;
        $pageIndex = 1;
        $filter=[
            "created_at"=>['<=',$end]
        ];
        $result = $userFac->query($filter, $pageSize, $pageIndex);
        $i=0;
        while($pageIndex<=($result["pageCount"])){   
            foreach($result["items"] as $resultitem){
                dump($resultitem->id);
                $i++;
                $this->makeDayReport($resultitem->id, $sts[$resultitem->id], $start, $end);
            }
            $pageIndex ++;
            $result = $userFac->query($filter, $pageSize, $pageIndex);   
        }
        return true;
    }
}
