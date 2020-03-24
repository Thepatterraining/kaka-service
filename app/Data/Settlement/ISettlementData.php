<?php
namespace App\Data\Settlement;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\LockData;
use App\Data\Utils\Formater;

abstract class ISettlementData extends IDataFactory
{
    
    protected $addedCreateUser = false;
    protected $journalAdapter = "";
    protected $journalData = "";
    protected $settleAdapter = "";
    protected $noPre = "";
    protected static $HOUR = "CYC01";
    protected static $DAY = "CYC02";
    protected static $WEEK = "CYC03";
    protected static $MONTH = "CYC04";
    protected static $USER = "CYC05";
    
    protected $modelclass = 'App\Model\Settlement\SysCashSettlement';
    protected $no = "settlement_no";
    abstract protected function caculateJobs($start, $end, $accountid, $item);
    
    public function makeSettlement($start, $end, $accountid, $settleType)
    {
        
        
        
        
        $lockKey = get_class($this)."start".$start."end".$end;
        $lk = new LockData();
        
        
        
        $startd = date_format(date_create($start), 'Y-m-d H:i:s');
        $endd = date_format(date_create($end), 'Y-m-d H:i:s');
        
        $journalFac = new $this->journalData();//CashJournalData();
        $jouranlAdp = new $this->journalAdapter();
        $settleAdp = new $this->settleAdapter();
        
        
        $settlefilter =[
        "filters"=>[
        "begin_time"=>['=',$startd],
        "end_time"=>['=',$endd],
        "accountid"=>['=',$accountid]
        ]
        
        ];
        
        $queryfilter = $settleAdp->getFilers($settlefilter);
        // dump($queryfilter);
        
        $item = $this->getFirst($queryfilter);
        //dump($items["totalSize"]);
        if ($item!=null) {
            return ;
        }
        if ($lk->lock($lockKey)===false) {
            return ;
        }
        $rptModel = $this->newitem();
        $rpt = array();
        $rpt["cyc"] = $settleType;
        
        $rpt["no"] = DocNoMaker::Generate($this->noPre);
        $rpt ["begin_time"] = $startd;
        $rpt["end_time"] = $endd;
        $rpt["accountid"] = $accountid;
        $settleAdp->saveToModel(false, $rpt, $rptModel);
        $this->create($rptModel);
        
        $rpt = $settleAdp->getDataContract($rptModel, null, true);
        
        $queryfilter = [
        "filters"=>[
        "datetime"=>[
        ['=',$start],
        ['=',$end]
        ],
        "accountid"=>$accountid
        ]
        
        ];
        $filter = $jouranlAdp->getFilers($queryfilter);
        
        $pageIndex = 1;
        $pageSize = 100;
        
        $itemIndex=0;
        
        
        $result = $journalFac->query($filter, $pageSize, $pageIndex);
        $pending =0.0;
        $ammount = 0.0;
        $in=0.0;
        $out =0.0;
 
        $res = [];
        $res["init_amount"]=0.0;
        $res["init_pending"]=0.0;
        $res ["result_amount"]=0.0;

        $res ["result_pending"] =0.0;

        if ($result["pageCount"]>0) {
            while ($pageIndex<=($result["pageCount"])) {
                foreach ($result["items"] as $item) {
                    $itemIndex ++;
                    $jounralItem = $jouranlAdp->getDataContract($item);
                    if ($itemIndex==($result["totalSize"])) {
                        $res["init_amount"] = $jounralItem["result_cash"] - $jounralItem["in"]+$jounralItem["out"];
                        $res["init_pending"] = $jounralItem["result_pending"] -  $jounralItem["pending"];
                    }
                    
                    $pending = $pending +  $jounralItem["pending"];
                    
                    $in = $in +  $jounralItem["in"];
                    $out = $out + $jounralItem["out"];
                }
                $pageIndex ++;
                $result = $journalFac->query($filter, $pageSize, $pageIndex);
            }
        } else {
               $queryfilter = [
                "filters"=>[
                    "datetime"=>[
                        '<=',
                        $start
                    ],
                    "accountid"=>$accountid
                ]
               ];
                $filter = $jouranlAdp->getFilers($queryfilter);
                $result = $journalFac->query($filter, 1, 1);
                
               foreach ($result["items"] as $item) {
                   $jounralItem = $jouranlAdp->getDataContract($item);
               
                   $res["init_amount"] = $jounralItem["result_cash"] ;
                   $res["init_pending"] = $jounralItem["result_pending"];
                }
        }


        $rpt ["count"] = $itemIndex;
        $rpt ["in"] = $in;
        $rpt ["out"] = $out;
        $rpt ["pending"] = $pending;
        $res ["result_pending"] =  $res["init_pending"] + $pending;

        $res ["result_amount"] =  $res["init_amount"]+$in-$out;
        
        
        $rpt["begin_amount" ]=  $res["init_amount"]; //期初 金额
        $rpt["begin_pending"] =  $res["init_pending"]; //期初 在途
        $rpt["end_amount"] = $res ["result_amount"]; //期末金额
        $rpt["end_pending"]=  $res ["result_pending"]; //期末 在途
        
        
        //dump($rpt);
        //dump($in);
        //dump($out);
        $rpt["count"]=$itemIndex;
        
        $settleAdp->saveToModel(false, $rpt, $rptModel);
        //dump($rptModel);
        $this->save($rptModel);
        $rpt = $this->caculateJobs($startd, $endd, $accountid, $rpt);
        $rpt["dvalue"] =$rpt["end_amount"]- $rpt["in"] + $rpt["out"]- $rpt["begin_amount"];
        $rpt["flat"] = (Formater::ceil($rpt["dvalue"], 2)===0.0 ?1:0);
        //dump($rpt["dvalue"] );
        $settleAdp->saveToModel(false, $rpt, $rptModel);
        $this->save($rptModel);
        $lk->unlock($lockKey);
        return $rpt;
    }
    
    
    public function makeHourSettlement($accountid)
    {
        
        $end = date("Y-m-d H:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 hours"));
        $start = date_format($start, 'Y-m-d H:i:s');
        
        
        return $this->makeSettlement($start, $end, $accountid, $this::$HOUR);
    }
    
    public function makeDaySettlement($accountid)
    {
        
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
        return $this->makeSettlement($start, $end, $accountid, $this::$DAY);
    }
}
