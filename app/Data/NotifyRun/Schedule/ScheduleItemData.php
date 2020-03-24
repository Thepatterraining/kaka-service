<?php
namespace App\Data\NotifyRun\Schedule;
use App\Data\Notify\INotifyDefault;
use App\Http\Controllers\Admin\ThirdPayment\IncomeDocList;
use App\Http\Utils\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Libs\ExcelMaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobReport;
use Illuminate\Support\Facades\Route;
use App\Data\Schedule\ScheduleJob;
use App\Data\Auth\UserData;
use Illuminate\Support\Facades\Storage;
use App\Data\Schedule\ScheduleItemData as ItemData;

class ScheduleItemData implements INotifyDefault
{
    public function notifyrun($data)
    {
        $items= Route::getRoutes();
        $itemData=new ItemData();

        $url = $data['sch_dealclass'];
        // var_dump($url);
        $userid = $data['created_id'];
        $docno  = $data['sch_itemno'];
        
        $id=$data['id'];
        $param=$itemData->get($id)->sch_param;
        $param = str_replace("\n", "", $param);
        $param = json_decode($param, true);
        
        
        $userFac = new UserData();
        $scheduleItemData=new ScheduleJob();
        $userInfo = $userFac->getByNo($userid);
        
        $mail= $userInfo ->auth_email;
        $name = $userInfo ->auth_name;
        if($mail == null ) {
            $data['sch_status'] = ScheduleJob::STATUS_FAIL;
            $scheduleItemData->saveReportJob($data);
            return ;
        }
        $fileName ="/tmp/".$docno.".xlsx";
     
        $storageFile ="/tmp/".$docno.".xlsx";
        $data['sch_status'] = ScheduleJob::STATUS_EXCUTE;
        $scheduleItemData->saveReportJob($data);
        foreach($items->get() as $routerIns){
            if($routerIns->uri == 'api/'.$url) {
                
                $controller =$routerIns->getController();
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                
                $controller ->getJobData(
                    $param["query"], function ($item,$index,$sheet,$map) {

                        if($index ===0) {
                             $col = 1;
                            foreach($map as $key=>$val){
                                $cell =  ExcelMaker::getCol($col).($index+1);
                       
                                $sheet->setCellValue($cell, $key);
                        
                                $col++;
                            }
                        }
                        $col = 1;
                        foreach($map as $key=>$val){

                            $cell =  ExcelMaker::getCol($col).($index+2);
                            $array = explode(".", $val);

                            $togetData = $item;
                            foreach($array as $i){

                                if(is_array($togetData) && array_key_exists($i, $togetData)) {
                                    $togetData = $togetData[$i];
                                } else { 
                                    break;
                                }
                            }
                            $sheet->setCellValue($cell, $togetData);
                        
                            $col++;
                        }
                    }, $sheet, $param["map"]
                );
                $writer = new Xlsx($spreadsheet);
               
                $writer->save($fileName);
                Mail::to([$mail])->send(new JobReport($mail, $name, $docno, $fileName));
               
                Storage::delete($storageFile);
                $data['sch_status'] = ScheduleJob::STATUS_SUCCESS;
                $scheduleItemData->saveReportJob($data);
            }
        }
    }
}