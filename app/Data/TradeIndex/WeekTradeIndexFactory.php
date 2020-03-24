<?php
namespace App\Data\TradeIndex;

use App\Data\Coin\ItemData;
use App\Data\Item\InfoData;
use App\Data\User\CoinJournalData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Model\User\User;
use App\Data\ITradeIndexFactory;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use App\Data\User\CoinAccountData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Data\Schedule\IWeekSchedule;

class WeekTradeIndexFactory extends ITradeIndexFactory implements IWeekSchedule
{
    protected $modelclass = 'App\Model\TradeIndex\WeekTradeIndex';
    
    /**
     * 实现每周填充k线
     *
     * @author zhoutao
     * @date   2017.8.25
     * 
     * 修改为public
     * @author zhoutao
     * @date   2017.8.25
     * 
     * 修改变量大小写
     * @author zhoutao
     * @date   2017.8.25
     */ 
    public function weekrun()
    {
        $projectData = new InfoData;
        $projModel = $projectData->newitem();
        $projects = $projModel->get();
        if (!$projects->isEmpty()) {
            foreach ($projects as $project) {
                $this->addLast($project->coin_type);
            }
        }
    }

    /**
     * 查询这一条的时间
     *
     * @author zhoutao
     * @date   2017.8.23
     */ 
    protected function getTime()
    {
        $timestr = time();
        $now_day = date('w', $timestr);
        //获取一周的第一天，注意第一天应该是星期天
        $sunday_str = $timestr - $now_day*60*60*24;
        $sunday = date('Y-m-d', $sunday_str);
        //获取一周的最后一天，注意最后一天是星期六
        $strday_str = $timestr + (6-$now_day)*60*60*24;
        $strday = date('Y-m-d', $strday_str);
        $times['timeOpen'] = date('Y-m-d', strtotime($sunday .'+1 day'));
        $times['timeClose'] = date('Y-m-d', strtotime($strday .'+1 day'));
        return $times;
    }

    /**
     * 查询上一条的时间
     *
     * @param  $number
     * @author zhoutao
     * @date   2017.8.23
     */ 
    protected function getLastTime($number)
    {
        $times = $this->getTime();
        $times['timeOpen'] = date('Y-m-d', strtotime($times['timeOpen'] . "-$number week"));
        $times['timeClose'] = date('Y-m-d', strtotime($times['timeClose'] . "-$number week"));
        return $times;
    }
    
}
