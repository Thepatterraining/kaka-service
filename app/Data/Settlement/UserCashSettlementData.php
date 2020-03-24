<?php
namespace App\Data\Settlement;

use App\Data\Settlement\ISettlementData;

use App\Data\Cash\RechargeData;
use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Http\Adapter\Cash\WithdrawalAdapter;

use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Data\Trade\TranactionOrderData;

use App\Data\User\UserData;
use App\Data\User\CashAccountData;

use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;

use App\Data\Activity\VoucherInfoData;
use App\Data\Utils\Formater;

use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;

use App\Data\Sys\PayUserData;
use App\Http\Adapter\Sys\PayUserAdapter;

use App\Data\Schedule\IDaySchedule;
use App\Data\Schedule\IHourSchedule;

/**
 * 用户现金对帐
 *
 *
 *
 */
class UserCashSettlementData extends ISettlementData implements IDaySchedule,IHourSchedule
{
    protected $journalAdapter = "App\Http\Adapter\User\CashJournalAdapter";
    protected $journalData = "App\Data\User\CashJournalData";
    protected $settleAdapter = "App\Http\Adapter\Settlement\SysCashAdapter";
    protected $noPre = "UCR";
    protected $modelclass = "App\Model\Settlement\UserCashSettlement";
    protected $no = "settlement_no";
    protected function caculateJobs($startd,$endd,$accountid,$item){

        $filter = [
            "filters"=>[
                "success"=>1,
                "chktime"=>[$startd,$endd],
                "userid"=>$accountid
            ]
        ];
        $in = 0;
        $out =0;
        //计算充值
        $rechargeAdp = new RechargeAdapter();
        $rechargeData = new RechargeData();
        $queryFilter = $rechargeAdp->getFilers($filter);    
  
        $pageSize = 100;
        $pageIndex = 1;

        $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
        //dump($result["pageCount"]);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $in  = $in +$resultitem->cash_recharge_sysamount;

            }
            $pageIndex ++;
            $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
            
        }/*
        $filter = [
            "filters"=>[
                "status"=>"CR03",
                "chktime"=>[$startd,$endd],
                "userid"=>$accountid
            ]
        ];
        $queryFilter = $rechargeAdp->getFilers($filter);
  
        $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
        //dump($result["pageCount"]);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $in  = $in +$resultitem->cash_recharge_sysamount;

            }
            $pageIndex ++;
            $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
            
        }
                $filter = [
            "filters"=>[
                "status"=>"CR04",
                "chktime"=>[$startd,$endd],
                "userid"=>$accountid
            ]
        ];
        $queryFilter = $rechargeAdp->getFilers($filter);
  
        $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
        //dump($result["pageCount"]);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $in  = $in +$resultitem->cash_recharge_sysamount;

            }
            $pageIndex ++;
            $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
            
        }
                $filter = [
            "filters"=>[
                "status"=>"CR05",
                "chktime"=>[$startd,$endd],
                "userid"=>$accountid
            ]
        ];
        $queryFilter = $rechargeAdp->getFilers($filter);
  
        $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
        //dump($result["pageCount"]);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $in  = $in +$resultitem->cash_recharge_sysamount;

            }
            $pageIndex ++;
            $result = $rechargeData->query($queryFilter,$pageSize,$pageIndex);
            
        }*/
        //dump("充值".$in);

        //计算提现
        $withdrawAdp = new WithdrawalAdapter();
        $withdrawalAdp = new WithdrawalAdapter();
        $queryFilter = $withdrawalAdp->getFilers($filter);     
        $withdrawalData = new WithdrawalData();
        $pageSize = 100;
        $pageIndex = 1;
        $result = $withdrawalData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $out  = $out +$resultitem->cash_withdrawal_amount;
            }
            $pageIndex ++;
            $result = $withdrawalData->query($queryFilter,$pageSize,$pageIndex);
            
        }      


        $transAdp = new TranactionOrderAdapter();
        $transData = new TranactionOrderData();
        //dump("提现".$out);
        //卖出成交
        $filter =  [
            "filters"=>[
                "success"=>1,
                "chktime"=>[$startd,$endd],
                "sellUserid"=>['=',$accountid]
            ]
        ];


        $queryFilter = $transAdp->getFilers($filter);     
        $pageSize = 100;
        $pageIndex = 1;
        $result = $transData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $in  = $in +$resultitem->order_cash;
            }
            $pageIndex ++;
            $result = $transData->query($queryFilter,$pageSize,$pageIndex);
            
        }      


        //买入成交
        $filter =  [
            "filters"=>[
                "success"=>1,
                "chktime"=>[$startd,$endd],
                "buyUserid"=>['=',$accountid]
            ]
        ];


        $queryFilter = $transAdp->getFilers($filter);     
        $pageSize = 100;
        $pageIndex = 1;
        $result = $transData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            
            
            foreach($result["items"] as $resultitem){
                $out  = $out +$resultitem->order_amount;
                if($resultitem->order_buycash_feetype ==="FR02")
                $out = $out + $resultitem->order_buycash_fee;
            }
            $pageIndex ++;
            $result = $transData->query($queryFilter,$pageSize,$pageIndex);
            
        }      



          //券的使用记录
        $voucherInfoData = new VoucherInfoData();
        $voucherData = new VoucherStorageData();
        $voucherAdp = new VoucherStorageAdapter();
          $filter = [
            "filters"=>[
                "status"=>"VOUS01",
                "usetime"=>[$startd,$endd],
                "userid"=>['=',$accountid]
            ]
        ];
        $queryFilter = $voucherAdp->getFilers($filter);   
        $pageSize = 100;
        $pageIndex = 1;
        $result = $voucherData->query($queryFilter,$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){
            foreach($result["items"] as $resultitem){

                $info = $voucherInfoData->getByNo($resultitem->vaucherstorage_voucherno);

                $in  = $in+$info->voucher_val2;

                }
            $pageIndex ++;
            $result = $voucherData->query($queryFilter,$pageSize,$pageIndex);
            
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
                $in  = $in+$info->pay_amount;
                
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
                $in+=$info->report_rbbuy_result;
                
            }
            $pageIndex ++;
            $result = $payUserData->query($queryFilter,$pageSize,$pageIndex);
            
        }


        $item["out"] = $out;
        $item["in"] = $in;
        return $item;
    }

    public function makeAllUserHourSettlement(){

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeHourSettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        return true;
    }

     public function makeAllUserDaySettlement(){

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDaySettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        return true;
    }
    public function makeAllUserSettlement($start,$end){


  
        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
           
                $this->makeSettlement($start,$end,$resultitem->id,$this::$USER);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        return true;
    }

     public function run(){

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDaySettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        return true;
    }

    public function hourrun(){

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([],$pageSize,$pageIndex);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
               
                $this->makeHourSettlement($resultitem->id);
            }
            $pageIndex ++;
            $result = $userFac->query([],$pageSize,$pageIndex);   
        }
        return true;
    }
}
