<?php
namespace App\Data\Item;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class QuartersData extends IDatafactory
{

    protected $modelclass = 'App\Model\Item\Quarters';

    /**
     * 查询同小区成交纪录
     *
     * @param   $coinType 代币类型
     * @return  array
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getQuarters($coinType)
    {
        $model = $this->newitem();
        $where['coin_type'] = $coinType;
        $info = $model->where($where)->get();
        if ($info->isEmpty()) {
            return [];
        }
        return $info;
    }

    public function getQuartersList($coinType)
    {
        $model = $this->newitem();
        $where['coin_type'] = $coinType;
        $info = $model->where($where)->get();
        if ($info->isEmpty()) {
            return [];
        }
        foreach ($info as $k => $v) {
            $arr['quarters' . $k]['orderSpace'] = $v->space;
            $arr['quarters' . $k]['orderDate'] = date('Y-m-d', strtotime($v->date));
            $arr['quarters' . $k]['orderLayout'] = $v->layout;
            $arr['quarters' . $k]['orderTotal'] = intval($v->total);
        }
        return $arr;
    }
}
