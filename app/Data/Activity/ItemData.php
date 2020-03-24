<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

class ItemData extends IDatafactory
{

    protected $no = 'activity_no';
    protected $modelclass = 'App\Model\Activity\Item';

    const COUPON_TYPE = 'AT01';

    /**
     * 添加活动子表
     *
     * @param   $no 活动编号
     * @param   $itemType 活动类型
     * @param   $voucherNo 现金券编号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addItem($no, $itemType, $voucherNo)
    {
        $model = $this->newitem();
        $model->activity_no = $no;
        $model->activity_itemtype = $itemType;
        $model->activity_itemno = $voucherNo;
        return $model->save();
    }

    public function getItem($no)
    {
        $where['activity_no'] = $no;
        $model = $this->newitem();
        return $model::where($where)->get();
    }

    /**
     * 查询活动号
     *
     * @param  $couponNo 代金券号
     * @param  $type 类型
     * @author zhoutao
     */
    public function getActivityNo($couponNo,$type)
    {
        $where['activity_itemtype'] = $type;
        $where['activity_itemno'] = $couponNo;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if (empty($info)) {
            return null;
        }
        return $info->activity_no;
    }
}
