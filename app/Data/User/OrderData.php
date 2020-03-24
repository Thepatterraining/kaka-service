<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Support\Facades\DB;

class OrderData extends IDatafactory
{

    protected $no = 'userorder_no';

    protected $modelclass = 'App\Model\User\Order';

    const BUY_TYPE = 'UORDER01';
    const SELL_TYPE = 'UORDER02';

    const COUPONS_DIS_TYPE = 'DCT01';

    /**
     * 添加交易记录
     *
     * @param   $jobNo 关联单据号 卖单或者买单
     * @param   $orderNo 成交单据号
     * @param   $coinType 代币类型
     * @param   $price 单价
     * @param   $coin 代币数量
     * @param   $disCountType 优惠类型
     * @param   $disCountNo 优惠券号
     * @param   $fee 手续费
     * @param   $ammount 最终成交金额
     * @param   $type 类型 UORDER01 买入 UORDER02 卖出
     * @param   null                                        $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.26
     */
    public function add($jobNo, $orderNo, $coinType, $price, $coin, $disCountType, $disCountNo, $fee, $ammount, $type, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $doc = new DocNoMaker();
        $no = $doc->Generate('UO');
        $model = $this->newitem();
        $model->userorder_no = $no;
        $model->userorder_type = $type;
        $model->userorder_jobno = $jobNo;
        $model->userorder_orderno = $orderNo;
        $model->userorder_cointype = $coinType;
        $model->userorder_price = $price;
        $model->userorder_coin = $coin;
        $model->userorder_discounttype = $disCountType;
        $model->userorder_discountno = $disCountNo;
        $model->userorder_fee = $fee;
        $model->userorder_ammount = $ammount;
        $model->userorder_userid = $userid;
        return $this->create($model);
    }

    /**
     * 根据成交单号和类型获取代币成交单
     *
     * @param   $orderNo 成交单号
     * @param   $type 类型
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserOrder($orderNo, $type)
    {
        $where['userorder_orderno'] = $orderNo;
        $where['userorder_type'] = $type;
        $where['userorder_userid'] = $this->session->userid;
        $model = $this->newitem();
        $info = $model->where($where)->first();
        return $info;
    }

    /**
     * 更新代金券使用记录
     *
     * @param $orderNo 成交单号
     * @param $voucherNo 代金券号
     */
    public function saveCoupons($orderNo, $voucherNo)
    {
        $where['userorder_orderno'] = $orderNo;
        $where['userorder_userid'] = $this->session->userid;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        $info->userorder_discountno = $voucherNo;
        $this->save($info);
    }

    /**
     * 查询优惠券号
     *
     * @param  $jobNo 成交单号
     * @param  $type 类型
     * @param  $userid 用户id
     * @author zhoutao 
     */
    public function getCoupon($jobNo,$type,$userid)
    {
        
        $where['userorder_orderno'] = $jobNo;
        $where['userorder_type'] = $type;
        $where['userorder_userid'] = $userid;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if (empty($info)) {
            return '未使用';
        }
        return $info->userorder_discountno;

    }

}
