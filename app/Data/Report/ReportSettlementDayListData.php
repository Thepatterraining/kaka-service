<?php

namespace App\Data\Report;

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
use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IMonthSchedule;
use App\Data\Notify\INotifyData;
use App\Data\Payment\PayChannelData;
use App\Data\User\UserData;
use App\Libs\ExcelMaker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Data\Excel\ITransactionOrderData;
use App\Data\Excel\ITransactionSellData;

class ReportSettlementDayListData implements IDaySchedule,IMonthSchedule
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

    public static function arraySaveToExcel($colArray,$items=null,$filename,$start,$end)
    {
            $sheetNum=0;
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("每日汇总表");

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

            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, "日期");
            $col++;
        foreach($title as $key=>$val){
                
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }
            // ExcelMaker::saveExcel($spreadsheet,$title,$ary,$filename);

            //foreach($items as $item){
                
                $row++;                
                $col=1;
                $start=$start->format("Y-m-d");
                $cell = ExcelMaker::getCol($col).$row;
                $sheet->setCellValue($cell, $start);
                $col++;

        foreach($colArray as $key=>$val){

            //    if(array_key_exists($val,$items)){
                $cell = ExcelMaker::getCol($col).$row;
                $sheet->setCellValue($cell, $val);
            //    }
            $col++;
        }             
          //  }   

            $sheetNum++;

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);

            $ary=array();
            //$ary['query']=[];
            $map['id']="id";
            $map['编号']="vaucherstorage_no";
            $map['优惠券编号']="vaucherstorage_voucherno";
            $map['活动编号']="vaucherstorage_activity";
            $map['用户id']="voucherstorage_userid";
            $map['关联单据号']="voucherstorage_jobno";
            $map['优惠券优惠金额']="voucherstorage_cutinit";
            $map['用户姓名']="user_name";
            $map['用户手机号码']="user_mobile";
            $map['实付金额']="real_pay_amount";

            // $date=date('Y-m-d');
            // $start=date_create($date);
            // $end=date_create($date);
            // date_add($start,date_interval_create_from_date_string("-1 days"));

            $voucherData=new VoucherStorageData();
            $voucherInfoData=new VoucherInfoData();
            $tranactionData=new TranactionOrderData();
            $userData=new UserData();

            $voucherInfo=$voucherData->getVoucherToday($start, $end);
            $ary=array();
        if(!$voucherInfo->isEmpty()) {
            foreach($voucherInfo as $voucher)
            {
                $tranactionInfo=$tranactionData->getByOrderNo($voucher->voucherstorage_jobno);
                $i=$voucher->voucherstorage_userid;
                $userInfo=$userData->getUser($i);

                $ary[$i]['id']=$voucher->id;
                $ary[$i]['vaucherstorage_no']=$voucher->vaucherstorage_no;
                $ary[$i]['vaucherstorage_voucherno']=$voucher->vaucherstorage_voucherno;
                $ary[$i]['vaucherstorage_activity']=$voucher->vaucherstorage_activity;
                $ary[$i]['voucherstorage_userid']=$voucher->voucherstorage_userid;
                $ary[$i]['voucherstorage_jobno']=$voucher->voucherstorage_jobno;

                $voucherNo=$voucher->vaucherstorage_voucherno;
                $voucherinfo=$voucherInfoData->getByNo($voucherNo);

                $ary[$i]['voucherstorage_cutinit']=$voucherinfo->voucher_val2;
                $ary[$i]['user_name']=$userInfo->user_name;
                $ary[$i]['user_mobile']=$userInfo->user_mobile;
                $ary[$i]['real_pay_amount']=$tranactionInfo->order_amount + $tranactionInfo->order_buycash_fee - $ary[$i]['voucherstorage_cutinit'];
            }
            // dump($ary);
            ExcelMaker::saveExcel($spreadsheet, $map, $ary, $filename, "每日用券表");  
        }
        else
            {
            ExcelMaker::saveExcel($spreadsheet, $map, $ary, $filename, "每日用券表"); 
        }
            $sheetNum++;

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);

            $items=array();
            $res['用户id']="user_id";
            $res['账户余额']="account_cash";
            $res['用户姓名']="user_name";
            $res['用户手机号']="user_mobile";

            $cashJournalFac=new CashJournalData();
            $userFac=new UserData();

            $pageSize = 100;
            $pageIndex = 1;
            $filter=[
                "created_at"=>['<=',$end]
            ];
            $result = $userFac->query($filter, $pageSize, $pageIndex);
            while($pageIndex<=($result["pageCount"])){      
                foreach($result["items"] as $resultitem){
                    $i=$resultitem->id;
                    $items[$i]['user_id']=$resultitem->id;   
                    $items[$i]['user_name']=$resultitem->user_name;
                    $items[$i]['user_mobile']=$resultitem->user_mobile;         
                    $sumCount=$cashJournalFac->newitem()->orderBy('id', 'desc')->where('usercash_journal_datetime', '<=', $end)
                        ->where('usercash_journal_userid', $resultitem->id)->first();
                    if(empty($sumCount)) {
                        $items[$i]['account_cash']=0;
                    }
                    else
                    {
                        $items[$i]['account_cash']=$sumCount->usercash_result_cash;
                    }
                    // dump($resultitem->id."  ".$items[$i]['account_cash']);
                    // if($items[$i]['account_cash']<0)
                    // {
                    //     exit ;
                    // }

                    // $res['sumCount']+=$sumCount;
                }
                $pageIndex ++;
                $result = $userFac->query($filter, $pageSize, $pageIndex);   
            }

            $sheetNum++;
            ExcelMaker::saveExcel($spreadsheet, $res, $items, $filename, "每日用户余额表");  

            $iTranactionOrderData=new ITransactionOrderData();
            $iTranactionOrderData->arraySaveToExcel($spreadsheet, $filename, $start, $end, $sheetNum);
            
            $sheetNum++;
            
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);

            $iTranactionSellData=new ITransactionSellData();
            $iTranactionSellData->arraySaveToExcel($spreadsheet, $filename, $start, $end, $sheetNum);

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
    }

    // 2017.9.28 统一业务逻辑 liu
    public function historyrun($start,$end,$date)
    {
        // $date=date("Y-m-d");

        $withdrawalFac = new ReportWithdrawalDayData();
        $wdFac=new WithdrawalData();
        $tradeFac = new ReportTradeDayData();
        $tranactionFac=new TranactionOrderData();
        $rechargeFac=new RechargeData();
        $thirdFac=new PayIncomedocsData(); 
        $rbBuyFac=new ReportUserrbSubDayData();
        $voucherStorageFac=new VoucherStorageData(); 
        $voucherInfoFac=new VoucherInfoData();
        $accountFac=new CashAccountData();
        $cashJournalFac=new CashJournalData();
        $bankAccountFac=new BankAccountData();
        $notifyData=new INotifyData();
        $payChannelData=new PayChannelData();
        $journalData=new JournalData();
        $userFac=new UserData();

        //线下充值总数
        $recharge=$rechargeFac->getCashCountDaily($start, $end);//newitem()->orderBy('created_at','desc')->where('report_date','>=',$start)->where('report_date','<',$end)->get();
        $res['rechargeOfflineCount']=$journalData->newitem()->whereBetween('cash_journal_datetime', [$start,$end])->where('cash_journal_type', 'CJ02')->sum('cash_journal_in');
        $res['rechargeThirdCount']=$rechargeFac->getThirdCashCountDaily($start, $end);

        //银行入账总数
        $res['settlementCount']=$res['rechargeOfflineCount']+$res['rechargeThirdCount'];

        //三方充值总数
        
        // $res['rechargeThirdCount']=$rechargeThird->cash_recharge_amount;
        //提现总数
        $res['withdrawalAllCount']=$wdFac->newitem()->whereBetween('created_at', [$start,$end])->sum('cash_withdrawal_amount');

        // 提现成功总数
        $res['withdrawalCount']=$withdrawalFac->newitem()->select('report_withdrawalcash')->where('report_end', '>', $start)->where('report_end', '<=', $end)->sum('report_withdrawalcash');

        // 交易金额总数
        $res['tradeCount']=$tranactionFac->newitem()->whereBetween('created_at', [$start,$end])->sum('order_amount');
        
        // 三方手续费总数
        $res['thirdFeeCount']=0;
        $thirdFee=$thirdFac->newitem()->where('income_endtime', '>', $start)->where('income_endtime', '<=', $end)->get();
        if(!$thirdFee->isEmpty()) {
            foreach($thirdFee as $fee)
            {
                $res['thirdFeeCount']+=$fee->income_fee;
            }
        }
        else
        {
            $res['thirdFeeCount']=0;
        }

        // 交易手续费总数
        $res['tradeFeeCount']=$tranactionFac->newitem()->whereBetween('created_at', [$start,$end])->sum('order_buycash_fee');
        // dump($res['tradeFeeCount']);
        // return true;
        // 提现手续费总数
        $res['withdrawalFeeCount']=$wdFac->newitem()->whereBetween('updated_at', [$start,$end])->where('cash_withdrawal_success', 1)->sum('cash_withdrawal_fee');
        // 返佣总数
        $res['rbBuyCount']=$rbBuyFac->newitem()->where('report_end', '>', $start)->where('report_end', '<=', $end)->sum('report_rbbuy_asc');
        // 理财金总数
        $voucher=$voucherStorageFac->getVoucherToday($start, $end);
        
        $res['voucherCount']=0;
        if(!$voucher->isEmpty()) {
            foreach($voucher as $value)
            {
                $voucherInfo=$voucherInfoFac->getByNo($value->vaucherstorage_voucherno);
                $res['voucherCount']=$res['voucherCount'] + $voucherInfo->voucher_val2;
            }
        }
        else
        {
            $res['voucherCount']=0;
        }
        // 平台余额总数
        // $res['sumCount']=$accountFac->newItem()->sum('account_cash');
        $res['userSumCount']=0;

        $pageSize = 100;
        $pageIndex = 1;
        $filter=[
            "created_at"=>['<=',$end]
        ];
        $result = $userFac->query($filter, $pageSize, $pageIndex);
        // dump($result["totalSize"]);
        // return $result;
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                 $sum=$cashJournalFac->newitem()->orderBy('id', 'desc')->where('usercash_journal_datetime', '<=', $end)
                     ->where('usercash_journal_userid', $resultitem->id)->first();
                if(empty($sum)) {  
                    $sumCount=0; 
                }
                else
                {
                    $sumCount=$sum->usercash_result_cash;
                }
                // dump($resultitem->id."  ".$sumCount);
                // if($sumCount<0)
                // {
                //     exit ;
                // }
                $res['userSumCount']+=$sumCount;
            }
            $pageIndex ++;
            $result = $userFac->query($filter, $pageSize, $pageIndex);   
        }
        $sysCashJournalData=new SysJournalData();

        $sysIn=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_in');
        $sysOut=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_out');
        $res['platformSumCount']=$sysIn-$sysOut;
        // return true;
        
        // $mail='sunhongshi@kakamf.com';
        // $name='孙宏拾';
        // Mail::to([$mail])->send(new SettlementReport($mail,$name,$date,$res));
        $event="NY01";
        $docno=$date."汇总";
        $fileName ="/tmp/".$docno.".xlsx";
        dump("excel complete");
        $this->arraySaveToExcel($res, null, $fileName, $start, $end);
        $notifyData->doJob($event, $res, $fileName, $start);
        dump('complete'); 
        return true;
    }

    public function monthrun()
    {
        $date=date("Y-m-1");
        $start=date_create($date);
        $end=date_create($date);
        date_add($start, date_interval_create_from_date_string("-1 month"));

        $this->historyrun($start, $end, $date);
        return true;
    }

    public function historyrun_month_7($start,$end,$date)
    {
        $withdrawalFac = new ReportWithdrawalDayData();
        $wdFac=new WithdrawalData();
        $tradeFac = new ReportTradeDayData();
        $tranactionFac=new TranactionOrderData();
        $rechargeFac=new ReportRechargeItemDayData();
        $thirdFac=new PayIncomedocsData(); 
        $rbBuyFac=new ReportUserrbSubDayData();
        $voucherStorageFac=new VoucherStorageData(); 
        $voucherInfoFac=new VoucherInfoData();
        $accountFac=new CashAccountData();
        $cashJournalFac=new CashJournalData();
        $bankAccountFac=new BankAccountData();
        $notifyData=new INotifyData();
        $payChannelData=new PayChannelData();
        $journalData=new JournalData();
        $userFac=new UserData();
        $invitationData=new InvitationData();
        $rakeBackTypeData=new RakebackTypeData();

        
        //银行入账总数
        $res['settlementCount']=$journalData->newitem()->whereBetween('cash_journal_datetime', [$start,$end])->sum('cash_journal_in');
        //线下充值总数
        $recharge=$rechargeFac->newitem()->orderBy('created_at', 'desc')->where('report_date', '>=', $start)->where('report_date', '<', $end)->get();
        $res['rechargeOfflineCount']=0;
        $res['rechargeThirdCount']=0;
        foreach($recharge as $demo)
        {
            $type=$payChannelData->getClassType($demo->report_recharge_channel_id);
            if($type=='FR00') {
                $res['rechargeOfflineCount']=$res['rechargeOfflineCount']+$demo->report_rechargecash;
            }
            else if($type=='FR01') {
                $res['rechargeThirdCount']=$res['rechargeThirdCount']+$demo->report_rechargecash;
            }
            else
            {
                continue;
            }
        }
        //提现总数
        $res['withdrawalAllCount']=$wdFac->newitem()->whereBetween('created_at', [$start,$end])->sum('cash_withdrawal_amount');

        // 提现成功总数
        $res['withdrawalCount']=$wdFac->newitem()->whereBetween('created_at', [$start,$end])->where('cash_withdrawal_success', 1)->sum('cash_withdrawal_amount');

        // 交易金额总数
        $res['tradeCount']=$tranactionFac->newitem()->whereBetween('created_at', [$start,$end])->sum('order_amount');
        
        // 三方手续费总数
        $res['thirdFeeCount']=0;
        $thirdFee=$thirdFac->newitem()->where('income_endtime', '>', $start)->where('income_endtime', '<=', $end)->get();
        if(!$thirdFee->isEmpty()) {
            foreach($thirdFee as $fee)
            {
                $res['thirdFeeCount']+=$fee->income_fee;
            }
        }
        else
        {
            $res['thirdFeeCount']=0;
        }

        // 交易手续费总数
        $res['tradeFeeCount']=$tranactionFac->newitem()->whereBetween('created_at', [$start,$end])->sum('order_buycash_fee');
        // dump($res['tradeFeeCount']);
        // return true;
        // 提现手续费总数
        $res['withdrawalFeeCount']=$wdFac->newitem()->whereBetween('updated_at', [$start,$end])->where('cash_withdrawal_success', 1)->sum('cash_withdrawal_fee');


        // 返佣总数
        $res['rbBuyCount']=0;
        $buyResult=$invitationData->getTotalBuy($start, $end);
        // dump($buyResult);
        if(!empty($buyResult)) {
            foreach($buyResult as $bResult)
            {
                $res['rbBuyCount']+=$rakeBackTypeData->getUserBuyRakeBackPast($bResult->cash);
            }
        }
        // $res['rbBuyCount']=$rbBuyFac->newItem()->where('report_end','>',$start)->where('report_end','<=',$end)->sum('report_rbbuy_asc');
        // 理财金总数
        $voucher=$voucherStorageFac->getVoucherToday($start, $end);
        
        $res['voucherCount']=0;
        if(!$voucher->isEmpty()) {
            foreach($voucher as $value)
            {
                $voucherInfo=$voucherInfoFac->getByNo($value->vaucherstorage_voucherno);
                $res['voucherCount']=$res['voucherCount'] + $voucherInfo->voucher_val2;
            }
        }
        else
        {
            $res['voucherCount']=0;
        }
        // 平台余额总数
        // $res['sumCount']=$accountFac->newItem()->sum('account_cash');
        $res['userSumCount']=0;

        $pageSize = 100;
        $pageIndex = 1;
        $filter=[
            "created_at"=>['<=',$end]
        ];
        $result = $userFac->query($filter, $pageSize, $pageIndex);
        // dump($result["totalSize"]);
        // return $result;
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                 $sum=$cashJournalFac->newitem()->orderBy('id', 'desc')->where('usercash_journal_datetime', '<=', $end)
                     ->where('usercash_journal_userid', $resultitem->id)->first();
                if(empty($sum)) {  
                    $sumCount=0;
                }
                else
                {
                    $sumCount=$sum->usercash_result_cash;
                }
                // dump($resultitem->id."  ".$sumCount);
                // if($sumCount<0)
                // {
                //     exit ;
                // }
                $res['userSumCount']+=$sumCount;
            }
            $pageIndex ++;
            $result = $userFac->query($filter, $pageSize, $pageIndex);   
        }

        $sysCashJournalData=new SysJournalData();

        $sysIn=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_in');
        $sysOut=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_out');
        $res['platformSumCount']=$sysIn-$sysOut;

        // return true;
        
        // $mail='sunhongshi@kakamf.com';
        // $name='孙宏拾';
        // Mail::to([$mail])->send(new SettlementReport($mail,$name,$date,$res));

        // dump($res);
        // return true;

        $event="NY01";
        $docno=$date."汇总";
        $fileName ="/tmp/".$docno.".xlsx";
        $this->arraySaveToExcel($res, null, $fileName, $start, $end);
        $address="liusimeng@kakamf.com";
        $name="孙宏拾";
        
        Mail::to([$address])->send(new SettlementReport($address, $name, $date, $res, $fileName));
        $notifyData->doJob($event, $res, $fileName, $start);
        dump('complete');
        return true;
    }
}
