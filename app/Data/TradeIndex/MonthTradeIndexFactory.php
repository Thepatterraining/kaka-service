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
use App\Data\Schedule\IMonthSchedule;

class MonthTradeIndexFactory extends ITradeIndexFactory implements IMonthSchedule
{
    protected $modelclass = 'App\Model\TradeIndex\MonthTradeIndex';
    
    /**
     * 实现每月填充k线
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
    public function monthrun()
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
        $times['timeOpen'] = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $times['timeClose'] = date('Y-m-d', strtotime($times['timeOpen']."+1 Month"));
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
        $times['timeOpen'] = date('Y-m-d', strtotime($times['timeOpen'] . "-$number month"));
        $times['timeClose'] = date('Y-m-d', strtotime($times['timeClose'] . "-$number month"));
        return $times;
    }
    
}
