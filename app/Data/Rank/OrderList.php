<?php
namespace App\Data\Rank;
use Illuminate\Support\Facades\Redis;
use App\Data\Rank\RedisList;
use Illuminate\Support\Facades\DB;

/**
 * 挂单列表操作类
 *
 * @author  geyunfei@kakamf.com
 * @date    Aug 18th,2017
 * @version 1.0
 */
class OrderList
{

 
    const BUY_KEY_PRE = 'trans_order_buy_';
    const SELL_KEY_PRE = 'trans_order_sell_';

    private $coin_type;
    private $sell_key ;
    private $buy_key;
    private $sell_list ;
    private $buy_list;



    /**
     * 构造函数
     *
     * @param coinType 代币类型
     */ 
    public function __construct($coinType)
    {
        $this->coin_type = $coinType;
        $this->sell_key = OrderList::SELL_KEY_PRE.$coinType;
        $this->buy_key = OrderList::BUY_KEY_PRE.$coinType;
        $this->sell_list = new RedisList($this->sell_key);
        $this->buy_list = new RedisList($this->buy_key);
    }
    /**
     * 增加卖单
     *
     * @param price 价格
     * @param count 数量
     **/
    public function AddSell($price,$count)
    {
        $this->sell_list ->Add($price, $count);


    }
    /**
     * 增加买单
     *
     * @param price 价格
     * @param count 数量
     **/
    public function AddBuy($price,$count)
    {
        $this->buy_list ->Add($price, $count);

    }

    /**
     * 增加成交
     *
     * @param price 价格
     * @param count 数量
     **/
    public function AddOrder($price,$count)
    {
        $this->sell_list ->Remove($price, $count);
        $this->buy_list ->Remove($price, $count);

    }

    /** 
     * 得到卖单列表
     *
     * @param  count 数量
     * @author zhoutao
     * @date   2017.8.30
     **/
    public function GetSell($count)
    {
        return DB::connection()->select('select sell_touser_showprice as price,sum((sell_count-sell_transcount)/sell_scale) as count from `transaction_sell` where `sell_status` in ("TS00","TS01") and `sell_leveltype` = "SL00" and `sell_cointype` = "'. $this->coin_type . '" group by sell_touser_showprice order by sell_touser_showprice asc limit 0,'.$count);
        // return  $this->sell_list ->Get($count);

    }

    /**
     * 得到买单列表
     *
     * @param  count 要返回的数量
     * @author zhoutao
     * @date   2017.8.30
     **/
    public function GetBuy($count)
    {
        return DB::connection()->select('select buy_touser_showprice as price,sum((buy_count-buy_transcount)/buy_scale) as count from `transaction_buy` where `buy_status` in ("TB00","TB01") and `buy_leveltype` = "BL00" and `buy_cointype` = "'. $this->coin_type . '" group by `buy_touser_showprice` order by `buy_touser_showprice` desc limit 0,'.$count);
        // return $this->buy_list->get($count);
        
    }
}