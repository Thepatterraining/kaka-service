<?php
namespace Cybereits\Common\Utils;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class ExcelMaker
{
    public static function getCol($col)
    {
        $colIndex = '';


        $c = $col;
        while ($c>0) {
            $colIndex = chr(64+($c%26==0?26:$c%26)).$colIndex;

            if ($c >26) {
                $c = floor(($c-1)/26);
            } else {
                break;
            }
        }
        return $colIndex;
    }
    public static function saveToExcel($colArray, $items, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row =1 ;
        $col = 1 ;
        foreach ($colArray as $key=>$val) {
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }
        dump($colArray);
        foreach ($items as $item) {
            $row++;
            $col =1;
            dump($item);
            foreach ($colArray as $key=>$val) {
                if (array_key_exists($val, $item)) {
                    $cell = ExcelMaker::getCol($col).$row;
                    $sheet->setCellValue($cell, $item[$val]);
                }
                $col++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
    }

    public static function saveModelToExcel($colArray, $items, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row =1 ;
        $col = 1 ;
        foreach ($colArray as $key=>$val) {
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }
        foreach ($items as $item) {
            $row++;
            $col =1;
            foreach ($colArray as $key=>$val) {
                $cell =  ExcelMaker::getCol($col).$row;
                $sheet->setCellValue($cell, $item->$val);
                $col++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
    }



    public static function saveExcel($spreadsheet, $colArray, $items, $filename, $sheetName=null)
    {
        $sheet = $spreadsheet->getActiveSheet();
        if ($sheetName) {
            $sheet->setTitle($sheetName);
        }
        $row =1 ;
        $col = 1 ;
        foreach ($colArray as $key=>$val) {
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }
        foreach ($items as $item) {
            $row++;
            $col =1;
            foreach ($colArray as $key=>$val) {
                dump($key.$val);
                if (array_key_exists($val, $item)) {
                    $cell = ExcelMaker::getCol($col).$row;
                    $sheet->setCellValue($cell, $item[$val]);
                }
                $col++;
            }
        }
    }


    public static function saveQueryExcel($sqlQuery, $filename)
    {

      //
        $items = DB::select($sqlQuery);
      
        if (count($items)===0) {
            return false;
        } else {
            $header = $items[0];
            foreach ($header as $col => $key) {
               $cols [$col] = $col;
            }
            self :: saveModelToExcel($cols, $items, $filename);
            return true;
        }
    }
}
