<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
use App\Data\Sys\RakebackTypeData;

class GetUserrbReportDayInfo extends Controller
{
    protected $validateArray=[

    ];

    protected $validateMsg = [

    ];

    /**
     * 查询用户返佣日报相关信息
     *
     * @author  liu
     * @version 0.1
     * @date    2017.6.19
     * @change  2017.8.10 添加当用户上月没有返佣的字段处理
     */
    //
    protected function run()
    {
        $request =$this->request->all();

        $data = new ReportUserrbSubDayData();
        $adapter = new ReportUserrbSubDayAdapter();
        $rakebackTypeData=new RakebackTypeData();

        $userId=$this->session->userid;
        $report=$data->getResultReportDaily($userId);
        if(empty($report)) {
            //$data->makeDayReportById($userId);
            $report=$data->getLastReportDesc($userId);
            if(empty($report)) {
                $items['personLastDay'] =0;
                $items['personSum']= 0;
                $items['moneyMonthNow']=0;
                $items['moneyMonthLast']=0;
                $moneySum=$items['moneyMonthNow'];
                $items['moneySum']=$rakebackTypeData->getUserBuyRakeBackBuyType($moneySum);
                $items['totalMoney']=0;
                return $this->Success($items);
            }
        }
        
        $items['personLastDay'] = $report->report_rbascinv;//昨日认购人数
        $items['personSum']= $report->report_currentinv;//邀请总人数
        $items['moneyMonthNow']=floor($report->report_rbbuy_asc * 100) / 100;//本日获取奖励(原本月获取佣金)

        $reportLastMonth=$data->getResultReportMonthly($userId);
        if($reportLastMonth->isEmpty()) {
            // $data->makeDayReportById($userId);
            $reportLastMonth=$data->getResultReportMonthly($userId);
        }
        $count=0;
        if(!$reportLastMonth->isEmpty()) {
            foreach($reportLastMonth as $value)     
            {
                $count=$count+$value->report_rbbuy_asc;
            }
            $items['moneyMonthLast']=floor($count *100)/100;//本月获取奖励（原上月已结算佣金）
        }
        else
        {
            $items['moneyMonthLast']=0;
        }
        /*
        if(!empty($reportLastMonth))
        {
            $items['moneyMonthLast']=floor($report->report_rbbuy_result * 100) / 100;//上月已结算佣金
        }
        else
        {
            $items['moneyMonthLast']=0;
        }*/

        $moneySum=$items['moneyMonthNow'];
        
        $items['moneySum']=$rakebackTypeData->getUserBuyRakeBackBuyType($moneySum);//目前返佣比率

        $result=$data->getResult($userId);
        $count=0;
        foreach($result as $value)
        {
            $count=$count+$value->report_rbbuy_result;
        }
        $init=$report->report_rbbuy_result;
        if($report->report_rbbuy_chkuser!=null) {
            $count=$count-$init;
        }
        $items['totalMoney']=floor(($count+$init) * 100) / 100;

        $this->Success($items);

    }
}
