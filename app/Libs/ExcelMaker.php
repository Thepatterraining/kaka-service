<?php
namespace App\Libs;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use Illuminate\Support\Facades\Route;
// use App\Data\Activity\VoucherStorageData;
// use App\Data\Activity\VoucherInfoData;
// use App\Data\User\CashAccountData;

class ExcelMaker
{


    public  static   function getCol($col)
    {
        $colIndex = '';


        $c = $col;
        while($c>0){


            $colIndex = chr(64+($c%26==0?26:$c%26)).$colIndex;

            if($c >26) {
                $c = floor(($c-1)/26);
            } else { 
                break;
            }
        

        }
        return $colIndex;
    }
    public static  function saveToExcel($colArray,$items,$filename)
    {


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
       
            $row =1 ;
            $col = 1 ;
        foreach($colArray as $key=>$val){
                
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }


        foreach($items as $item){
                
            $row++;                
            $col =1;
            foreach($colArray as $key=>$val){

                if(array_key_exists($val, $item)) {
                    $cell = ExcelMaker::getCol($col).$row;
                    $sheet->setCellValue($cell, $item[$val]);
                }


                $col++;

            }
              

        }   

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
    }

    public static  function saveModelToExcel($colArray,$items,$filename)
    {


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
       
            $row =1 ;
            $col = 1 ;
        foreach($colArray as $key=>$val){
                
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }


        foreach($items as $item){
               
            $row++;                
            $col =1;
            foreach($colArray as $key=>$val){
                $cell =  ExcelMaker::getCol($col).$row;
                $sheet->setCellValue($cell, $item->$val);
                $col++;

            }


        }   

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            
    }



    public static function saveExcel($spreadsheet,$colArray,$items,$filename,$sheetName=null)
    {

            $sheet = $spreadsheet->getActiveSheet();
        if($sheetName) {
            $sheet->setTitle($sheetName);
        }
            $row =1 ;
            $col = 1 ;
        foreach($colArray as $key=>$val){
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }


        foreach($items as $item){
                
            $row++;                
            $col =1;
            foreach($colArray as $key=>$val){

                if(array_key_exists($val, $item)) {
                    $cell = ExcelMaker::getCol($col).$row;
                    $sheet->setCellValue($cell, $item[$val]);
                }


                $col++;

            }
              

        }   
    }
}
