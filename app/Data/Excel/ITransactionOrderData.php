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
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Libs\ExcelMaker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class ITransactionOrderData extends IDataFactory
{

    const BUY_LEVELTYPE="BL01";
    public static function arraySaveToExcel($spreadsheet,$filename,$start,$end,$i)
    {
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($i);

            $title['单据号']="no";
            $title['代币']="type";
            $title['交易份额']="count";
            $title['交易单价']="price";
            $title['买方id']="buyUserid";
            $title['买方姓名']="buyUserName";
            $title['卖方id']="sellUserid";
            $title['卖方姓名']="sellUserName";
            $title['卖方收入']="amount";
            $title['卖方手续费']="sellCoinFee";
            $title['卖方实得']="sellGet";
            $title['买方支出']="amount";
            $title['买方手续费']="buyCashFee";
            $title['买方总支出']="buyPay";
            $title['买方用券金额']="voucherCount";
            $title['隶属市场']="level";
            $title['时间']="chktime";

            $voucherData=new VoucherStorageData();
            $voucherInfoData=new VoucherInfoData();
            $tranactionData=new TranactionOrderData();
            $tranactionAdapter=new TranactionOrderAdapter();
            $userData=new UserData();

            $model=$tranactionData->newitem();
            $result=$model->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get();
            $tmpValue=0;
            $colArray=array();
        foreach($result as $value)
            {
            $colArray[$tmpValue]=$tranactionAdapter->getFromModel($value, true);
            $colArray[$tmpValue]['voucherCount']=0;

            $buyUserInfo=$userData->get($colArray[$tmpValue]['buyUserid']);
            if(!$buyUserInfo->user_name) {
                $colArray[$tmpValue]['buyUserName']=$buyUserInfo->user_name;
            }
            else
            {
                $colArray[$tmpValue]['buyUserName']=null;
            }

            $sellUserInfo=$userData->get($colArray[$tmpValue]['sellUserid']);
            if(!$sellUserInfo->user_name) {
                $colArray[$tmpValue]['sellUserName']=$sellUserInfo->user_name;
            }
            else
            {
                $colArray[$tmpValue]['sellUserName']=null;
            }

            if($colArray[$tmpValue]["buyLevelType"]==ITransactionOrderData::BUY_LEVELTYPE) {
                $colArray[$tmpValue]["level"]="一级";
            }
            else
            {
                $colArray[$tmpValue]["level"]="二级";
            }
            $voucherInfo=$voucherData->getVoucherByToNo($value->order_no);
                
            if(!$voucherInfo->isEmpty()) {
                foreach($voucherInfo as $info)  
                {
                    $countInfo=$voucherInfoData->newitem()
                        ->where('vaucher_no', $info->vaucherstorage_voucherno)
                        ->first();
                    $colArray[$tmpValue]['voucherCount']+=$countInfo->voucher_val2;
                }
            }
            $colArray[$tmpValue]["sellGet"] = $colArray[$tmpValue]["amount"] - $colArray[$tmpValue]["sellCoinFee"];
            $colArray[$tmpValue]["buyPay"] = $colArray[$tmpValue]["amount"] + $colArray[$tmpValue]["buyCashFee"] - $colArray[$tmpValue]["voucherCount"];
            $tmpValue++;
        }
            ExcelMaker::saveExcel($spreadsheet, $title, $colArray, $filename, "分析表格"); 
            
    }   
}
