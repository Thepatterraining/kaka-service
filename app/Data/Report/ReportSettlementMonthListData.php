<?php

namespace App\Data\Report;

use Illuminate\Http\Request;

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
use App\Data\Excel\ISettlementData;
use App\Mail\NotifyReport;

class ReportSettlementMonthListData
{

    public static function arraySaveToExcel($colArray,$items=null,$filename,$start,$end)
    {
            $sheetNum=0;
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex($sheetNum);
            $sheet = $spreadsheet->getActiveSheet();
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
        foreach($title as $key=>$val){
                
            $cell = ExcelMaker::getCol($col).$row;
            $sheet->setCellValue($cell, $key);
            $col++;
        }
            // ExcelMaker::saveExcel($spreadsheet,$title,$ary,$filename);

            //foreach($items as $item){
                
                $row++;                
                $col=1;
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
            // $items=Route::getRoutes();
            // dump($items);
            // $api="api/v2/admin/voucher/day/getvoucher";

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
            
        if(!$voucherInfo->isEmpty()) {
            foreach($voucherInfo as $voucher)
            {
                $tranactionInfo=$tranactionData->getByOrderNo($voucher->voucherstorage_jobno);
                $i=$voucher->voucherstorage_userid;
                $userInfo=$userData->getUser($i);
                if(!$userInfo) {
                    continue;
                }

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
            

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(2);
            // $api="/api/v2/admin/day/getusercashaccountlist";
            // $controller=$api->getController();
            $items=array();
            $res['用户id']="user_id";
            $res['账户余额']="account_cash";

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
                    $sumCount=$cashJournalFac->newItem()->orderBy('id', 'desc')->where('usercash_journal_datetime', '<=', $end)
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
            ExcelMaker::saveExcel($spreadsheet, $res, $items, $filename);  

            // $accountData=new CashAccountData();
            // $accountInfo=$accountData->getAccountToday();
            // if(!$accountInfo->isEmpty())
            // {
            //     foreach($accountInfo as $account)
            //     {   
            //         $i=$account->id;
            //         $items[$i]['user_id']=$account->account_userid;
            //         $items[$i]['account_cash']=$account->account_cash;
            //     }
            //     // dump($ary);
            //     ExcelMaker::saveExcel($spreadsheet,$res,$items,$filename);  
            // }

            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
    }


    public function historyrun($start,$end,$date)
    {
        // $date=date("Y-m-d");

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
        $rcFac=new RechargeData();

        //银行入账总数
        $res['settlementCount']=$journalData->newitem()->whereBetween('cash_journal_datetime', [$start,$end])->sum('cash_journal_in');
        //线下充值总数
        // $recharge=$rechargeFac->newitem()->orderBy('created_at','desc')->where('report_date','>=',$start)->where('report_date','<',$end)->get();
        $res['rechargeOfflineCount']=$rcFac->newitem()->whereBetween('created_at', [$start,$end])
            ->where('cash_recharge_type', 'CRT01')->where('cash_recharge_success', 1)->sum('cash_recharge_sysamount');
        $res['rechargeThirdCount']=$rcFac->newitem()->whereBetween('created_at', [$start,$end])
            ->where('cash_recharge_type', 'CRT02')->where('cash_recharge_success', 1)->sum('cash_recharge_sysamount');
        // foreach($recharge as $demo)
        // {
        //     $type=$payChannelData->getClassType($demo->report_recharge_channel_id);
        //     if($type=='FR00')
        //     {
        //         $res['rechargeOfflineCount']=$res['rechargeOfflineCount']+$demo->report_rechargecash;
        //     }
        //     else if($type=='FR01')
        //     {
        //         $res['rechargeThirdCount']=$res['rechargeThirdCount']+$demo->report_rechargecash;
        //     }
        //     else
        //     {
        //         continue;
        //     }
        // }

        //三方充值总数
        
        // $res['rechargeThirdCount']=$rechargeThird->cash_recharge_amount;
        //提现总数
        $res['withdrawalAllCount']=$wdFac->newitem()->whereBetween('created_at', [$start,$end])->sum('cash_withdrawal_amount');

        // 提现成功总数
        $res['withdrawalCount']=$wdFac->newitem()->whereBetween('created_at', [$start,$end])->where('cash_withdrawal_status', 'CW01')->sum('cash_withdrawal_amount');

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
        $res['withdrawalFeeCount']=$wdFac->newItem()->whereBetween('updated_at', [$start,$end])->where('cash_withdrawal_success', 1)->sum('cash_withdrawal_fee');
        // 返佣总数
        $res['rbBuyCount']=$rbBuyFac->newItem()->where('report_end', '>', $start)->where('report_end', '<=', $end)->sum('report_rbbuy_asc');
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
        // 用户余额总数
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
                 $sum=$cashJournalFac->newItem()->orderBy('id', 'desc')->where('usercash_journal_datetime', '<=', $end)
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
        //平台余额总数
        $sysIn=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_in');
        $sysOut=$sysCashJournalData->newitem()->where('syscash_journal_datetime', '<=', $end)->sum('syscash_journal_out');
        $res['platformSumCount']=$sysIn-$sysOut;

        return $res;
    }

    public function run()
    {
        $date=date("Y-m-1");
        $start=date_create($date);
        $end=date_create($date);
        $tmp_start=date_create($date);
        $tmp_end=date_create($date);
        $tmp_date=date("Y-m-1", strtotime("-1 month"));
        date_add($start, date_interval_create_from_date_string("-1 month"));
        date_add($tmp_start, date_interval_create_from_date_string("-1 month"));
        date_add($tmp_end, date_interval_create_from_date_string("-1 month"));
        date_add($tmp_end, date_interval_create_from_date_string("1 day"));
        dump($end);
        $items=array();
        while($tmp_start!=$end)
        {
            dump($tmp_start);
            $startdate=date_format($tmp_start, "Y-m-d");
            $enddate=date_format($tmp_end, "Y-m-d");
            // dump("Make Monthly Jobs : {$startdate}->${enddate}");
            // $scheduleItemData=new ScheduleItemData();
            $items[]=$this->historyrun($tmp_start, $tmp_end, $tmp_date);
            date_add($tmp_start, date_interval_create_from_date_string("1 day"));
            date_add($tmp_end, date_interval_create_from_date_string("1 day"));
            $tmp_date=date_format($tmp_start, "Y-m-d");
        }
        // $event="NY01";
        $docno=$date."汇总";
        $fileName ="/tmp/".$docno.".xlsx";
        $iSettlementData=new ISettlementData();
        $iSettlementData->arraySaveToExcel($items, null, $fileName, $start, $end, "ES01");

        $address="sunhongshi@kakamf.com";
        $name="孙宏拾";
        Mail::to([$address])->send(new NotifyReport($address, $name, "月汇总", $fileName));
        // $notifyData->doJob($event,$res,$fileName,$start);
        dump('complete'); 
        return true;
    }
}
