<?php
namespace App\Data\User;

use App\Data\Sys\ConfigData;
use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\User\CashAccountData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Data\Report\ReportData;
use App\Data\Sys\LockData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
use App\Data\Auth\AccessToken;
use App\Http\Adapter\User\UserRebateRankAdapter;

class UserRebateRankdayData extends IDatafactory
{

    protected $modelclass = 'App\Model\User\UserRebateRankday';
    
    /**
     * 存储排行
     *
     * @param start 日报开始时间
     **/
    public function saveRank($start)
    {
        
        $lk = new LockData();

        $startd = date_format(date_create($start), 'Y-m-d 0:00:00');
        $end=date_create($start);
        date_add($end, date_interval_create_from_date_string("-1 days"));
        $lastStartd=date_format($end, 'Y-m-d 0:00:00');
        $reportUserrbSubDayData=new ReportUserrbSubDayData();
        $userRebateRankDayAdapter=new UserRebateRankAdapter();
        $reportUserrbSubDayAdapter = new ReportUserrbSubDayAdapter();
        

        //$array=$reportUserrbSubDayData->getTop($start);
        for($i=1;$i<=20;$i++)
        {
            //$lockKey = get_class($this)."start".$start;
            $model=$this->newitem();
            $res=array();
            $array=$reportUserrbSubDayData->getTop($startd, $i);
            //取不到日报信息时，返回空阻断操作
            if(empty($array)) {
                return ;
                //$array=$reportUserrbSubDayData->getTop($lastStartd,$i);
            }
            $res['rankDate']=$start;
            $res['rankUser']=$array->report_user;
            $res['rankIndex']=$i;
            $res['rankRebate']=$array->report_rbbuy_result;
            $check=$model->where('rank_user', $res['rankUser'])->where('rank_date', $res['rankDate'])->first();
            if(!empty($check)) {
                continue;
            }
            //$lockKey = get_class($this)."start".$start."report_user".$array->report_user;
            //$reportfilter =[
            //"filters"=>[
            //"report_date"=>$startd,
            //"report_user"=>$array->report_user,
            //]
            //];
        
            //$queryfilter = $userRebateRankDayAdapter->getFilers($reportfilter);
            //$items = $this->query($queryfilter, 1, 1);
            //dump($items["totalSize"]);
            //if ($items["totalSize"]>0) {
            //    return ;
            //}
            //if ($lk->lock($lockKey)===false) {
            //    return ;
            //}

            $userRebateRankDayAdapter->saveToModel(false, $res, $model);
            $this->create($model);
        }
        //$lk->unlock($lockKey);

    }

    /**
     * 得到排行
     *
     * @param date 日报开始时间
     * @param loop 排名
     **/
    public function getRank($date,$loop)
    {
        $model=$this->newitem();
        $result=$model->orderBy('rank_index', 'asc')
        //->groupBy('rank_user')
            ->where('rank_date', $date)
            ->distinct()
            ->skip($loop-1)
            ->take(1)
            ->first();
        return $result;
    }

    /**
     * 得到用户个人排行
     *
     * @param userId 用户id
     **/
    public function getRankByUserId($userId)
    {
        $model=$this->newitem();
        $result=$model->orderBy('rank_date', 'desc')
            ->where('rank_user', $userId)
            ->get();
        return $result;
    }

    /**
     * 生成排名报表
     **/
    public function makeDayReport()
    {
        
        $end = date("Y-m-d 00:00:00");
        $start = date_create($end);
        date_add($start, date_interval_create_from_date_string("-1 days"));
        $start = date_format($start, 'Y-m-d H:i:s');
        return $this->saveRank($start);
    }

    /**
     * 生成所有报表
     */ 
    public function makeAllDayReport()
    {

        $userFac = new UserData();
        
        $pageSize = 100;
        $pageIndex = 1;
        $result = $userFac->query([], $pageSize, $pageIndex);
        //dump($result);
        while($pageIndex<=($result["pageCount"])){  
            foreach($result["items"] as $resultitem){
                
                $this->makeDayReport();
            }
            $pageIndex ++;
            $result = $userFac->query([], $pageSize, $pageIndex);   
        }
        return true;
    }

    /**
     * 得到全部排行
     *
     * @param date 日报开始时间
     **/
    public function getAllRank($date)
    {
        $model=$this->newitem();
        $result=$model->orderBy('rank_index', 'asc')
        //->groupBy('rank_user')
            ->where('rank_date', $date)
            ->get();
        return $result;
    }
}