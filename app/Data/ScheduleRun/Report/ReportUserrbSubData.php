<?php
namespace App\Data\ScheduleRun\Report;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Sys\UserData;
use App\Data\Activity\InvitationData;
use App\Data\Cash\RechargeData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionBuyData;

class ReportUserrbSubData implements IDaySchedule
{
    //
    public function run()
    {
        $userFac = new UserData();
        $invitationData=new InvitationData();
        $tranactionData=new TranactionOrderData();
        $tranactionBuyData=new TranactionBuyData();
        $rechargeData=new RechargeData();
        $reportUserrbSubDayData=new ReportUserrbSubDayData();
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
        $info=$reportUserrbSubDayData->getTop(date_format($endDate, "Y-m-d"), $idCount);
      
        while(empty($info))
        {
            date_add($endDate, date_interval_create_from_date_string("-1 days"));
            $idCount=$userFac->getMaxIdDay($endDate);
            $info=$reportUserrbSubDayData->getTop(date_format($date, "Y-m-d"), $idCount);
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
                    $reportUserrbSubDayData->makeDayReport($resultitem->id, $sts[$resultitem->id], date_create($tmp_start), $tmp_end);
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
}