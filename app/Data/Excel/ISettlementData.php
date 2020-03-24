<?php

namespace App\Data\Excel;

use App\Data\IDataFactory;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use App\Data\Report\ReportSumsDayData;
// use App\Data\Report\ReportWithdrawalDayData;
// use App\Data\Report\ReportRechargeItemDayData;
// use App\Data\Report\ReportTradeDayData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Payment\PayIncomedocsData;
use App\Data\Cash\WithdrawalData;
use App\Data\Cash\BankAccountData;
use App\Data\Cash\JournalData;
use App\Data\Cash\RechargeData;
use App\Data\Sys\RakebackTypeData;
use App\Data\Activity\InvitationData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Activity\VoucherInfoData;
use Illuminate\Support\Facades\Mail;
use App\Data\User\CashAccountData;
use App\Data\Sys\CashJournalData as SysJournalData;
use App\Data\User\CashJournalData;
use App\Mail\SettlementReport;
use App\Data\Notify\INotifyData;
use App\Data\Payment\PayChannelData;
use App\Data\User\UserData;
use App\Libs\ExcelMaker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ISettlementData extends IDataFactory{

    const DAY='ES01';
    const HOUR='ES02';

    public static function arraySaveToExcel($colArray,$items=null,$filename,$start,$end,$status)
    {
            $sheetNum=0;
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("汇总表");

            $title['线下充值总数']="rechargeOfflineCount";
            $title['三方充值总数']="rechargeThirdCount";
            $title['银行入账总数']="settlementCount";
            $title['提现总数']="withdrawalAllCount";
            $title['提现成功总数']="withdrawalCount";
            $title['交易金额总数']="tradeCount";
            $title['三方手续费总数']="thirdFeeCount";
            $title['交易手续费总数']="tradeFeeCount";
            $title['提现手续费总数']="withdrawalFeeCount";
            $title['返佣总数']="rbBuyCount";
            $title['理财金总数']="voucherCount";
            $title['用户余额总数']="userSumCount";
            $title['平台余额总数']="platformSumCount";
            $col =1 ;
            $row = 1 ;
            $tmp_start=$start;

            foreach($title as $key=>$val){
                
                $cell = ExcelMaker::getCol($col).$row;
                $sheet->setCellValue($cell,$key);
                $col++;
            }
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell,'起始时间');
            $col++; 
            // ExcelMaker::saveExcel($spreadsheet,$title,$ary,$filename);

            foreach($colArray as $value){
                
                $row++;                
                $col=1;
                foreach($value as $key=>$val){

                //    if(array_key_exists($val,$items)){
                        $cell = ExcelMaker::getCol($col).$row;
                        $sheet->setCellValue($cell,$val);
                //    }
                    $col++;
                }
                switch($status)
                { 
                    case self::DAY:
                    {
                        $cell = ExcelMaker::getCol($col).$row;
                        $tmp_start=date_format($tmp_start,"Y-m-d");
                        $sheet->setCellValue($cell,$tmp_start);
                        $tmp_start=date_create($tmp_start);
                        date_add($tmp_start,date_interval_create_from_date_string("1 day"));
                        break;
                    }
                    case self::HOUR:
                    {
                        $cell = ExcelMaker::getCol($col).$row;
                        $tmp_start=date_format($tmp_start,"Y-m-d");
                        $sheet->setCellValue($cell,$tmp_start);
                        $tmp_start=date_create($tmp_start);
                        date_add($tmp_start,date_interval_create_from_date_string("1 hour"));
                        break;
                    }
                    default:
                    {
                        break;
                    }
                }   
            }    
            $sheetNum++;
            $iTranactionOrderData=new ITransactionOrderData();
            $iTranactionOrderData->arraySaveToExcel($spreadsheet,$filename,$start,$end,$sheetNum);

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
	}   
}
