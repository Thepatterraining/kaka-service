<?php
namespace App\Data\Settlement;

use App\Data\Settlement\ISettlementData;

use App\Data\Cash\RechargeData;
use App\Data\Cash\WithdrawalData;
use App\Http\Adapter\Cash\RechargeAdapter;
use App\Http\Adapter\Cash\WithdrawalAdapter;
use App\Http\Adapter\Trade\TranactionOrderAdapter;
use App\Data\Trade\TranactionOrderData;

/**
 * 资金池现金对帐
 */
class CashSettlementData extends ISettlementData
{
    protected $journalAdapter = "App\Http\Adapter\Cash\JournalAdapter";
    protected $journalData = "App\Data\Cash\JournalData";
    protected $settleAdapter = "App\Http\Adapter\Settlement\SysCashAdapter";
    protected $noPre = "SCR";
    protected $modelclass = "App\Model\Settlement\CashSettlement";
    protected $no = "settlement_no";

    protected function caculateJobs($startd, $endd, $accountid, $item)
    {

        $filter = [
            "filters"=>[
                "success"=>1,
                "chktime"=>[$startd,$endd]
            ]
        ];


        //充值记录
        $rechargeAdp = new RechargeAdapter();
        $queryFilter = $rechargeAdp->getFilers($filter);
        $withdrawAdp = new WithdrawalAdapter();

        $rechargeData = new RechargeData();
        $pageSize = 100;
        $pageIndex = 1;
        $in = 0;
        $result = $rechargeData->query($queryFilter, $pageSize, $pageIndex);
        // dump($result["pageCount"]);
        while ($pageIndex<=($result["pageCount"])) {
            foreach ($result["items"] as $resultitem) {
                $in  = $in +$resultitem->cash_recharge_sysamount;
            }
             $pageIndex ++;
            $result = $rechargeData->query($queryFilter, $pageSize, $pageIndex);
        }

        //提现记录
        $withdrawalAdp = new WithdrawalAdapter();
        $queryFilter = $withdrawalAdp->getFilers($filter);
        $withdrawalData = new WithdrawalData();
        $pageSize = 100;
        $pageIndex = 1;
        $out = 0;
        $result = $withdrawalData->query($queryFilter, $pageSize, $pageIndex);
        ///dump($result["pageCount"]);
        while ($pageIndex<=($result["pageCount"])) {
            foreach ($result["items"] as $resultitem) {
                $out  = $out +$resultitem->cash_withdrawal_out;
            }
             $pageIndex ++;
            $result = $withdrawalData->query($queryFilter, $pageSize, $pageIndex);
        }
        $item["out"] = $out;
        $item["in"] = $in;
        return $item;
    }
}
