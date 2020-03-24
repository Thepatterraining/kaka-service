<?php
namespace App\Data;

use Illuminate\Support\Facades\Log;
use App\Http\Utils\RaiseEvent;
use App\Data\Trade\TranactionOrderData;
use App\Data\Sys\CoinData;
use App\Data\User\UserTypeData;
use App\Data\Project\ProjectInfoData;
 

abstract class ITradeIndexFactory
{
    protected $modelclass;
    protected $session;

    private $turnoverVal = 0;
    private $volumeVal = 0;
    private $times;

    const PRICE_SCALE = 100;
    const VOLUME_SCALE = 10000;
    const TURNOVER_SCALE = 100;
    const COIN_SCALE = 0.01;

    public function __construct()
    {   
        $this->session = resolve('App\Http\Utils\Session');
        $this->times = $this->getTime();
    }

    /**
     * 查询这一条的时间
     *
     * @author zhoutao
     * @date   2017.8.23
     */ 
    protected function getTime()
    {
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
    }


    /**
     * 查询之前的k线，没有加上
     *
     * @param  $coinType 代币类型
     * @param  $number 之前的纪录 默认为上一条
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 修改为protected
     * @author zhoutao
     * @date   2017.8.25
     */ 
    protected function addLast($coinType, $number = 1)
    {
        $times = $this->getLastTime($number);
        $this->times = $times;

        $where['coin_type'] = $coinType;
        $where['time_close'] = $times['timeClose'];
        $where['time_open'] = $times['timeOpen'];
        $model = new $this->modelclass;
        $info = $model::where($where)->first();

        if (empty($info)) {
            $last = $model::where('coin_type', $coinType)->orderBy('id', 'desc')->first();

            if (empty($last)) {
                return true;
            }
            $price = $last->price_close;
            $price /= self::PRICE_SCALE;
            $this->add($coinType, $price, 0, 0);
            return $this->addLast($coinType, ++$number);
        }
        return true;
        
    }

    /**
     * 增加
     *
     * @param  $coinType 代币类型
     * @param  $price 价格
     * @author zhoutao
     * @date   2017.8.17
     */ 
    private function add($coinType, $price)
    {
        $times = $this->times;
        $timeOpen = $times['timeOpen'];
        $timeClose = $times['timeClose'];

        $volumeVal = $this->volumeVal;
         
        $turnoverVal = $this->turnoverVal;

        $price *= self::PRICE_SCALE;
        $model = new $this->modelclass;
            $model->coin_type = $coinType;
            $model->price_open = $price;
            $model->price_close = $price;
            $model->price_high = $price;
            $model->price_low = $price;
            $model->price_scale = self::PRICE_SCALE;
            $model->volume_scale = self::VOLUME_SCALE;
            $model->turnover_scale = self::TURNOVER_SCALE;
            $model->coin_scale = self::COIN_SCALE;
            $model->volume_val = $volumeVal * self::VOLUME_SCALE;
            $model->turnover_val = $turnoverVal * self::TURNOVER_SCALE;
            $model->time_open = $timeOpen;
            $model->time_close = $timeClose;
            $model->save();
    }

    /**
     * 获取换手率
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.17
     * 
     * 获取比例因子改成从projectInfoData取
     * @author zhoutao
     * @date   20171.10.19
     */ 
    private function getTurnoverVal($coinType) 
    {
        $coinData = new CoinData;
        $coin = $coinData->getCoin($coinType);
        if (empty($coin) || $coin->syscoin_account_cash == 0) {
            return 0;
        }
        $sysCoins = $coin->syscoin_account_cash;

        $volumeVal = $this->getVolumeVal($coinType);

        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);
        $scale = $projectInfo->project_scale;
        $sysCoins /= $scale;
        
        $turnoverVal = $volumeVal / $sysCoins;
        $this->turnoverVal = $turnoverVal;
        return $turnoverVal;
        
    }

    /**
     * 获取成交量
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.17
     */ 
    private function getVolumeVal($coinType)
    {
        $times = $this->times;
        $timeOpen = $times['timeOpen'];
        $timeClose = $times['timeClose'];
        $orderData = new TranactionOrderData;
        $orderModel = $orderData->newitem();
        $volumeVal = $orderModel->where('order_coin_type', $coinType)
            ->whereBetween('created_at', [$timeOpen,$timeClose])
            ->sum('order_touser_showcount');
        $this->volumeVal = $volumeVal;
        return $volumeVal;
    }

    /**
     * 更新
     *
     * @param  $info 
     * @param  $coinType 代币类型
     * @param  $price 价格
     * @author zhoutao
     * @date   2017.8.17
     * 
     * 去掉了数量
     * @author zhoutao
     * @date   2017.8.31
     */ 
    private function saveFac($info, $coinType, $price)
    {
        $volumeVal = $this->getVolumeVal($coinType);
        $turnoverVal = $this->getTurnoverVal($coinType);
        $price *= self::PRICE_SCALE;

        $info->price_close = $price;
        if ($price > $info->price_high) {
            $info->price_high = $price;
        }
        if ($price < $info->price_low) {
            $info->price_low = $price;
        }
            $info->volume_val = $volumeVal * self::VOLUME_SCALE ;
            $info->turnover_val = $turnoverVal * self::TURNOVER_SCALE;
            $info->save();
    }
    
    /**
     * 增加交易
     *
     * @param $coinType 代币类型
     * @param $price 价格
     * @param $author zhoutao
     * @param $date 2017.8.17
     */
    public function addTrade($coinType, $price)
    {
        // $date = date('Y-m-d H:i:s');
        $times = $this->getTime();
        
        $where['coin_type'] = $coinType;
        $where['time_close'] = $times['timeClose'];
        $where['time_open'] = $times['timeOpen'];
        $model = new $this->modelclass;
        $info = $model::where($where)
                        // ->where('time_close','>',$date)
                        // ->where('time_open','<',$date)
                        ->first();
        if (empty($info)) {
            //重置时间
            $this->times = $times;
            //新增k线
            $this->add($coinType, $price);
            
        } else {
            //更新k线
            $this->saveFac($info, $coinType, $price);
        }

    }

    /**
     * 获取k线列表
     *
     * @param  $coinType 代币类型
     * @param  $open 开始时间
     * @param  $close 结束时间
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 增加了排序
     * @author zhoutao
     * @date   2017.8.24
     */ 
    public function queryIndex($coinType, $open, $close)
    {
        $where['coin_type'] = $coinType;

        $model = new $this->modelclass;
        $indexs = $model::where($where)
                        ->where('time_close', '<=', $close)
                        ->Where('time_open', '>=', $open)
                        ->orderBy('time_close', 'asc')
                        ->get();
        if (empty($indexs)) {
            return [];
        }
        foreach ($indexs as $index) {
            $index->price_open /= self::PRICE_SCALE;
            $index->price_close /= self::PRICE_SCALE;
            $index->price_high /= self::PRICE_SCALE;
            $index->price_low /= self::PRICE_SCALE;
            $index->volume_val /= self::PRICE_SCALE;
            $index->turnover_val /= self::PRICE_SCALE;
        }
        
        return $indexs;
    }
   
}
