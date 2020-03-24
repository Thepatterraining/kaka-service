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
use App\Data\Schedule\IHourSchedule;

class HourTradeIndexFactory extends ITradeIndexFactory implements IHourSchedule
{
    protected $modelclass = 'App\Model\TradeIndex\HourTradeIndex';
    
    /**
     * 实现每小时填充k线
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
    public function hourrun()
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
     * 
     * 加入分钟
     * @author zhoutao
     * @date   2017.8.25
     */ 
    protected function getTime()
    {
        $times['timeOpen'] = date('Y-m-d H:00:00');
        $times['timeClose'] = date('Y-m-d H:00:00', strtotime('+1 hour'));
        return $times;
    }

    /**
     * 查询上一条的时间
     *
     * @param  $number
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 加入分钟
     * @author zhoutao
     * @date   2017.8.25
     */ 
    protected function getLastTime($number)
    {
        $times = $this->getTime();
        $times['timeOpen'] = date('Y-m-d H:00:00', strtotime($times['timeOpen'] . "-$number hour"));
        $times['timeClose'] = date('Y-m-d H:00:00', strtotime($times['timeClose'] . "-$number hour"));
        return $times;
    }

    /**
     * 返回model
     *
     * @author zhoutao
     * @date   2017.9.15
     */
    public function newitem()
    {
        $modelclass = $this->modelclass;
        return new $modelclass;
    }
}
