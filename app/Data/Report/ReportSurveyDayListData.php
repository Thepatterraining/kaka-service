<?php

namespace App\Data\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;
use App\Libs\ExcelMaker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Mail\SurveyReport;
use App\Data\Activity\SurveyData;

class ReportSurveyDayListData implements IDaySchedule,IHourSchedule
{
    //
    public function run()
    {
        $date=date("Y-m-d");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 days"));

        $this->historyrun($start, $end, $date);
        return true;
    }

    public function hourrun()
    {
        $date=date("Y-m-d H:00:00");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 hours"));

        $this->historyrun($start, $end, $date);
        return true;
    }

    public static function arraySaveToExcel($res,$items=null,$filename,$start,$end)
    {
            $sheetNum=0;
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);
            $sheet = $spreadsheet->getActiveSheet();

            $title['用户姓名']="survey_name";
            $title['用户手机号']="survey_mobile";
            $title['用户所在城市']="survey_city";
            $title['身份证号']="survey_idno";
            $title['是否在本平台注册']="survey_reg";
            $title['注册id']="survey_regid";
            $title['渠道码']="survey_invcode";
            $title['出生年月日']="survey_birth";
            $title['身份证前六位']="survey_idpre";
            $title['收入区间']="survey_income";
            $title['提交时间']="created_at";
            $col =1 ;
            $row = 1 ;

            $ary=array();
            $i=0;
        if(!$res->isEmpty()) {
            foreach($res as $surveyInfo)
            {
                $ary[$i]['survey_name']=$surveyInfo->survey_name;
                $ary[$i]['survey_mobile']=$surveyInfo->survey_mobile;
                $ary[$i]['survey_city']=$surveyInfo->survey_city;
                $ary[$i]['survey_idno']=$surveyInfo->survey_idno;
                    
                $ary[$i]['survey_invcode']=$surveyInfo->survey_invcode;
                $ary[$i]['survey_birth']=$surveyInfo->survey_birth;
                $ary[$i]['survey_idpre']=$surveyInfo->survey_idpre;
                $ary[$i]['survey_income']=$surveyInfo->survey_income;
                $ary[$i]['created_at']=$surveyInfo->created_at;

                if($surveyInfo->survey_reg==0) {
                    $ary[$i]['survey_reg']="否";
                    $ary[$i]['survey_regid']=null;
                }
                else
                {
                    $ary[$i]['survey_reg']="是";
                    $ary[$i]['survey_regid']=$surveyInfo->survey_regid;
                }
                $i++;
            }
            ExcelMaker::saveExcel($spreadsheet, $title, $ary, $filename, "调查明细表");  
        }
        else
            {
            ExcelMaker::saveExcel($spreadsheet, $title, $ary, $filename, "调查明细表"); 
        }
 
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
    }

    // 2017.9.28 统一业务逻辑 liu
    public function historyrun($start,$end,$date)
    {
        $surveyData=new SurveyData();
        $res=$surveyData->newitem()->where('created_at', '>', $start)->where('created_at', '<=', $end)->get();
        
        if($res->isEmpty()) {
            return false;
        }
        $mail=['tanbochao@kakamf.com','xuyang@kakamf.com','haojinyi@kakamf.com','chendonghao@kakamf.com'];
        $ccMail=['chentianhang@kakamf.com'];
        
        $event="NY01";
        $docno=$date."活动汇总";
        $fileName ="/tmp/".$docno.".xlsx";
        dump("excel complete");
        $this->arraySaveToExcel($res, null, $fileName, $start, $end);
        Mail::to($mail)->cc($ccMail)->send(new SurveyReport($mail, $date, $res, $fileName));
        // $notifyData->doJob($event,$res,$fileName,$start);
        dump('complete'); 
        return true;
    }
}
