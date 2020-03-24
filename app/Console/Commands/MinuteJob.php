<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ThirdPayment\IncomeDocList;
use App\Http\Utils\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Libs\ExcelMaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use  App\Mail\JobReport;
use Illuminate\Support\Facades\Route;
use App\Data\Schedule\ScheduleJob;
use App\Data\Auth\UserData;
use Illuminate\Support\Facades\Storage;


class MinuteJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kk:minute';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'the minute job.';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $items= Route::getRoutes();
        
        $jobFac = new ScheduleJob();
        $jobFac->getUserExcelJob(
            function ($jobInfo,$index,$items) {
                $url = $jobInfo ->sch_dealclass;
                // var_dump($url);
                $userid = $jobInfo->created_id;
                $docno  = $jobInfo->sch_itemno;
            
                $param = json_decode($jobInfo->sch_param, true);
            
                $userFac = new UserData();
            
                $userInfo = $userFac->getByNo($userid);
            
                $mail= $userInfo ->auth_email;
                $name = $userInfo ->auth_name;
                if($mail == null ) {
                    $jobInfo->sch_status = ScheduleJob::STATUS_FAIL;
                    $jobInfo->save();
                    return ;
                }
                $fileName ="/tmp/".$docno.".xlsx";
        

                $storageFile ="/tmp/".$docno.".xlsx";
                $jobInfo->sch_status = ScheduleJob::STATUS_EXCUTE;
                $jobInfo->save();
                foreach($items->get() as $routerIns){
                    if($routerIns->uri == 'api/'.$url) {
                    
                        dump($param);
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
				    if(is_array($togetData) && count($togetData)>0)
					$togetData = json_encode($togetData);
                                    $sheet->setCellValue($cell, $togetData);
                            
                                    $col++;
                                }
                            }, $sheet, $param["map"]
                        );
                        $writer = new Xlsx($spreadsheet);
                
                        $writer->save($fileName);
                        Mail::to([$mail])->send(new JobReport($mail, $name, $docno, $fileName));
                
                        Storage::delete($storageFile);
                        $jobInfo->sch_status = ScheduleJob::STATUS_SUCCESS;
                        $jobInfo->save();
                    }
                }
            
            }, $items
        );
        
        
        
        
    }
}
