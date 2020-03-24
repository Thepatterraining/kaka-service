<?php
namespace App\Data\Trade;

use App\Data\IDataFactory;

class TradeViewData extends IDataFactory
{
    protected $modelclass = 'App\Model\Trade\TransactionView';

    protected $no = 'no';

    const SELL = 'TS';
    const BUY = 'TB';
   
    /**
     * 查询未成交纪录
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.22
     * 
     * 增加分页
     * @param  $pageSize 每页数量
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.13
     */ 
    public function getOpenOrders($coinType, $pageIndex, $pageSize)
    {
        $model = $this->modelclass;
        $where['cointype'] = $coinType;
        $where['userid'] = $this->session->userid;
        $status = ['TB00','TB01','TS00','TS01'];
        // $orders = $model::whereIn('status',$status)->where($where)->orderBy('datetime','desc')->get();
        $tmp = $model::whereIn('status', $status)->where($where);
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->orderBy('datetime', 'desc')->get();
        $result['totalSize'] = $tmp->count();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        $result["pageCount"]= ($result['totalSize']-$result['totalSize']%$result["pageSize"])/$result["pageSize"] +($result['totalSize']%$result["pageSize"]===0?0:1);
        return $result;
    }

    /**
     * 查询已成交纪录
     *
     * @param  $pageIndex 页码
     * @param  $pageSize 每页数量
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.22
     * 改了一个变量 $where
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 在已成交里面查询撤销的单
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function getCloseOrders($pageSize, $pageIndex, $coinType)
    {
        $model = $this->modelclass;
        $status = ['TB02','TS02','TB01','TS01','TB03','TS03'];
        $where['cointype'] = $coinType;
        $where['userid'] = $this->session->userid;
        $tmp = $model::whereIn('status', $status)->where($where);
        $items = $tmp->offset($pageSize*($pageIndex-1))->limit($pageSize)->orderBy('datetime', 'desc')->get();
        $result['totalSize'] = $tmp->count();
        $result['items'] = $items->isEmpty() ? [] : $items;
        $result["pageIndex"]=$pageIndex;
        $result["pageSize"]=$pageSize;
        $result["pageCount"]= ($result['totalSize']-$result['totalSize']%$result["pageSize"])/$result["pageSize"] +($result['totalSize']%$result["pageSize"]===0?0:1);
        return $result;
    }
}
