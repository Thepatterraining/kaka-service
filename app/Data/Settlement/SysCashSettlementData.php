<?php
namespace App\Data\Settlement;

use App\Data\Settlement\ISettlementData;
use App\Http\Adapter\Sys\CashFeeAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Data\Trade\TranactionOrderData;
use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use App\Http\Data\Schedule\IDaySchedule;
use App\Data\Activity\VoucherInfoData;

/**
 * 平台现金对帐
 *
 *
 *
 */
class SysCashSettlementData extends ISettlementData
{
    protected $journalAdapter = "App\Http\Adapter\Sys\CashJournalAdapter";
    protected $journalData = "App\Data\Sys\CashJournalData";
    protected $settleAdapter = "App\Http\Adapter\Settlement\SysCashAdapter";
    protected $noPre = "PCR";
    protected $modelclass = "App\Model\Settlement\SysCashSettlement";
    protected $no = "settlement_no";

    protected function caculateJobs($startd, $endd, $accountid, $item)
    {

        $filter = [
            "filters"=>[
                "success"=>1,
                "chktime"=>[$startd,$endd]
            ]
        ];
        $out = 0;
        $in = 0;
        $transAdp = new TranactionOrderAdapter();
        $queryFilter = $transAdp->getFilers($filter);
        $withdrawAdp = new WithdrawalAdapter();
               
        //交易记录

        $transData = new TranactionOrderData();
        $pageSize = 100;
        $pageIndex = 1;
       


        $result = $transData->query($queryFilter, $pageSize, $pageIndex);
        //dump($result["pageCount"]);
        while ($pageIndex<=($result["pageCount"])) {
            foreach ($result["items"] as $resultitem) {
                $in  = $in +$resultitem->order_cash_fee;
            }
             $pageIndex ++;
            $result = $transData->query($queryFilter, $pageSize, $pageIndex);
        }
        //提现记录
        $withdrawalAdp = new WithdrawalAdapter();
        $queryFilter = $withdrawalAdp->getFilers($filter);
        $withdrawalData = new WithdrawalData();
        $pageSize = 100;
        $pageIndex = 1;

        $result = $withdrawalData->query($queryFilter, $pageSize, $pageIndex);
        while ($pageIndex<=($result["pageCount"])) {
            foreach ($result["items"] as $resultitem) {
                $in  = $in +$resultitem->cash_withdrawal_fee;
            }
             $pageIndex ++;
            $result = $withdrawalData->query($queryFilter, $pageSize, $pageIndex);
        }

        //券的使用记录
        $voucherInfoData = new VoucherInfoData();
        $voucherData = new VoucherStorageData();
        $voucherAdp = new VoucherStorageAdapter();
          $filter = [
            "filters"=>[
                "status"=>"VOUS01",
                "usetime"=>[$startd,$endd]
            ]
          ];
          $queryFilter = $voucherAdp->getFilers($filter);
          $pageSize = 100;
          $pageIndex = 1;
          $result = $voucherData->query($queryFilter, $pageSize, $pageIndex);
          while ($pageIndex<=($result["pageCount"])) {
              foreach ($result["items"] as $resultitem) {
                  $info = $voucherInfoData->getByNo($resultitem->vaucherstorage_voucherno);

                  $out  = $out+$info->voucher_val2;
                }
                $pageIndex ++;
                $result = $voucherData->query($queryFilter, $pageSize, $pageIndex);
            }
        
        //返现
        $payUserData = new PayUserData();
        $payUserAdp = new PayUserAdapter();
          $filter = [
            "filters"=>[
                "ischeck"=>['=',1],
                "checktime"=>[$startd,$endd],
                "userid"=>['=',$accountid]
            ]
        ];
        $queryFilter = $payUserAdp->getFilers($filter);   
        $pageSize = 100;
        $pageIndex = 1;
        $result = $payUserData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            foreach($result["items"] as $resultitem){

                $info = $payUserData->getByNo($resultitem->pay_no);
                $out  = $out+$info->pay_amount;
                
            }
            $pageIndex ++;
            $result = $payUserData->query($queryFilter,$pageSize,$pageIndex);
            
        }      

        //返佣
        $reportUserrbSubDayData = new ReportUserrbSubDayData();
        $reportUserrbSubDayAdp = new ReportUserrbSubDayAdapter();
          $filter = [
            "filters"=>[
                "rbbuyIspay"=>['=',1],
                "rbBuyChktime"=>[$startd,$endd],
                "user"=>['=',$accountid]
            ]
        ];
        $queryFilter = $reportUserrbSubDayAdp->getFilers($filter);   
        $pageSize = 100;
        $pageIndex = 1;
        $result = $reportUserrbSubDayData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            foreach($result["items"] as $resultitem){

                $info = $reportUserrbSubDayData->getByNo($resultitem->id);
                $out+=$info->report_rbbuy_result;
                
            }
            $pageIndex ++;
            $result = $payUserData->query($queryFilter,$pageSize,$pageIndex);
            
        }

            $item["out"] = $out;
            $item["in"] = $in;
            return $item;
    }
}
