<?php

namespace App\Data\Excel;

use App\Data\IDataFactory;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use App\Data\Report\ReportSumsDayData;
// use App\Data\Report\ReportWithdrawalDayData;
// use App\Data\Report\ReportRechargeItemDayData;
// use App\Data\Report\ReportTradeDayData;
use App\Data\Trade\TranactionSellData;
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
use App\Http\Adapter\Trade\TranactionSellAdapter;
use App\Libs\ExcelMaker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ITransactionSellData extends IDataFactory{

    const SELL_STATUSTYPE_PART_TRADE="TS01";
    const SELL_STATUSTYPE_ALL_TRADE="TS02";
    const SELL_STATUSTYPE_PART_REVOKE="TS03";
    const SELL_STATUSTYPE_ALL_REVOKE="TS04";

    const SELL_LEVELTYPE_COMMON="BL00";
    const SELL_LEVELTYPE_VOUCHER="BL01";

    public static function arraySaveToExcel($spreadsheet,$filename,$start,$end,$i)
    {
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($i);

            $title['单据号']="no";
            $title['代币']="cointype";
            $title['挂单数量']="count";
            $title['限价']="limit";
            $title['手续费率']="feerate";
            $title['挂单总价']="ammount";
            $title['挂单用户id']="userid";
            $title['卖方姓名']="username";
            $title['成交数量']="transcount";
            $title['成交金额']="transammount";
            $title['卖单状态']="statustype";
            $title['最后成交时间']="lasttranstime";
            $title['类型']="level";
            $title['挂单时间']="selltime";

            $voucherData=new VoucherStorageData();
            $voucherInfoData=new VoucherInfoData();
            $tranactionData=new TranactionSellData();
            $tranactionAdapter=new TranactionSellAdapter();
            $userData=new UserData();

            $model=$tranactionData->newitem();
            $result=$model->where('created_at','>=',$start)->where('created_at','<=',$end)->get();
            $tmpValue=0;
            $colArray=array();
            foreach($result as $value)
            {
                $colArray[$tmpValue]=$tranactionAdapter->getFromModel($value,true);
                
                $userInfo=$userData->get($colArray[$tmpValue]['userid']);
                if(!$userInfo->user_name)
                {
                    $colArray[$tmpValue]['username']=$userInfo->user_name;
                }
                else
                {
                    $colArray[$tmpValue]['username']=null;
                }

                switch($colArray[$tmpValue]["status"])
                {
                    case ITransactionSellData::SELL_STATUSTYPE_PART_TRADE:
                    {
                        $colArray[$tmpValue]["statustype"]="部分成交"; 
                        break;   
                    }
                    case ITransactionSellData::SELL_STATUSTYPE_ALL_TRADE:
                    {
                        $colArray[$tmpValue]["statustype"]="全部成交";    
                        break;
                    }
                    case ITransactionSellData::SELL_STATUSTYPE_PART_REVOKE:
                    {
                        $colArray[$tmpValue]["statustype"]="部分撒单";    
                        break;
                    }
                    case ITransactionSellData::SELL_STATUSTYPE_ALL_REVOKE:
                    {
                        $colArray[$tmpValue]["statustype"]="全部撒单";    
                        break;
                    }
                    default:
                    {
                        $colArray[$tmpValue]["statustype"]=null;
                        break;
                    }
                }

                switch($colArray[$tmpValue]["leveltype"])
                {
                    case ITransactionSellData::SELL_LEVELTYPE_VOUCHER:
                    {
                        $colArray[$tmpValue]["level"]="理财金可用";  
                        break; 
                    }
                    case ITransactionSellData::SELL_LEVELTYPE_COMMON:
                    {
                        $colArray[$tmpValue]["level"]="普通";
                        break;
                    }
                    default:
                    {
                        $colArray[$tmpValue]["level"]=null;
                        break;
                    }
                }
            }
        ExcelMaker::saveExcel($spreadsheet,$title,$colArray,$filename,"卖单表格"); 
	}   
}
