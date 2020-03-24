<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\User\CoinAccountAdapter;
use Illuminate\Support\Facades\DB;
use App\Data\Cash\WithdrawalData;
use App\Data\Cash\RechargeData;
use App\Http\Adapter\AdapterFac;
use App\Data\Trade\TranactionOrderData;
use App\Data\Item\InfoData;
use App\Data\Activity\VoucherInfoData;
use App\Data\Product\InfoData as ProductInfoData;
use App\Data\Bonus\ProjBonusData;
use App\Data\Bonus\ProjBonusItemData;
use App\Data\Project\ProjectInfoData;
use App\Http\Adapter\User\CashOrderAdapter;

class CashOrderData extends IDatafactory
{

    protected $no = 'usercashorder_no';

    protected $modelclass = 'App\Model\Cash\Order';

    const BUY_TYPE = 'UCORDER01';
    const SELL_TYPE = 'UCORDER02';
    const WITHDRAWAL_TYPE = 'UCORDER03';
    const WITHDRAWAL_FEE_TYPE = 'UCORDER04';
    const RECHARGE_TYPE = 'UCORDER05';
    const SUBSCRIPTION_TYPE = 'UCORDER07';
    const VOUCHER_TYPE = 'UCORDER08';
    const REBATE_TYPE = 'UCORDER09';
    const BACK_NOW_TYPE = 'UCORDER10';
    const BONUS_TYPE = 'UCORDER11';
    const BORROW_TYPE = 'UCORDER12';
    const USER_RETURN_TYPE = 'UCORDER13';

    private $_typeToData = [
        CashOrderData::BUY_TYPE => 'App\Data\Trade\TranactionOrderData',
        CashOrderData::SELL_TYPE => 'App\Data\Trade\TranactionOrderData',
        CashOrderData::WITHDRAWAL_TYPE => 'App\Data\Cash\WithdrawalData',
        CashOrderData::RECHARGE_TYPE => 'App\Data\Cash\RechargeData',
        CashOrderData::SUBSCRIPTION_TYPE => 'App\Data\Trade\TranactionOrderData',
        CashOrderData::VOUCHER_TYPE => 'App\Data\User\CashJournalData',
        CashOrderData::BONUS_TYPE => 'App\Data\Bonus\ProjBonusData',
        CashOrderData::BORROW_TYPE => 'App\Data\Lending\LendingDocInfoData',
        CashOrderData::USER_RETURN_TYPE => 'App\Data\Lending\LendingDocInfoData',
    ];

    /**
     * 添加交易记录
     *
     * @param   $jobNo 关联单据号 卖单或者买单
     * @param   $price 金额
     * @param   $type 类型  UCORDER01 买入 UCORDER02 卖出 UCORDER03 提现 UCORDER04 提现手续费 UCORDER05 充值 UCORDER06 交易手续费 UCORDER07 认购 UCORDER08 冲正
     * @param   null                                                                                                                                                                   $userid 用户id
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.27
     */
    public function add($jobNo, $price, $type, $balance, $userid = null)
    {
        if ($userid == null) {
            $userid = $this->session->userid;
        }
        $doc = new DocNoMaker();
        $no = $doc->Generate('UCO');
        $model = $this->newitem();
        $model->usercashorder_no = $no;
        $model->usercashorder_type = $type;
        $model->usercashorder_jobno = $jobNo;
        $model->usercashorder_price = $price;
        $model->usercashorder_userid = $userid;
        $model->usercashorder_balance = $balance;
        return $this->create($model);
    }

    /**
     * 查询现金账单的关联表信息，并返回
     *
     * @param  $no 现金账单编号
     * @author zhoutao
     * 
     * 调用原来item.infoData的查询项目信息改成查询project.projectInfoData
     * @author zhoutao
     * @date   2017.10.18
     * 
     * 增加typeName 字段
     * @author zhoutao
     * @date   2017.11.15
     * 
     * 加个容错，查不到优惠为0
     * @author zhoutao
     * @date   2017.11.17
     */
    public function getCashOrder($no)
    {
        $cashOrderInfo = $this->getByNo($no);
        
        $cashOrderAdapter = new CashOrderAdapter;
        $cashOrder = $cashOrderAdapter->getDataContract($cashOrderInfo);
        $jobNo = $cashOrderInfo->usercashorder_jobno;
        $type = $cashOrderInfo->usercashorder_type;
        $jobInfo = $this->getCashOrderJob($type, $jobNo);
        $adapterFac = new AdapterFac();
        $projectInfoData = new ProjectInfoData;
        $jobInfo = $adapterFac->getDataContract($jobInfo);
        $jobInfo['typeNo'] = $type;
        $jobInfo['typeName'] = $cashOrder['type']['name'];
        //获取项目信息
        $coinType = array_get($jobInfo, 'type', null);
        $orderArray = [CashOrderData::BUY_TYPE,CashOrderData::SELL_TYPE,CashOrderData::SUBSCRIPTION_TYPE];
        if (in_array($type, $orderArray)) {
            $jobInfo['type'] = '';
            $itemData = new InfoData();
            if (!empty($coinType)) {
                $projectInfo = $projectInfoData->getByNo($coinType);
                $jobInfo['type'] = empty($projectInfo) ? '' : $projectInfo->project_name;
            }
        }
        $lendingDocInfoArray = [self::BORROW_TYPE, self::USER_RETURN_TYPE];
        if (in_array($type, $lendingDocInfoArray)) {
            $coinType = array_get($jobInfo, 'coinType', null);
            $jobInfo['type'] = '';
            $itemData = new InfoData();
            if (!empty($coinType)) {
                $projectInfo = $projectInfoData->getByNo($coinType);
                $jobInfo['type'] = empty($projectInfo) ? '' : $projectInfo->project_name;
            }
            $jobInfo['chktime'] = $jobInfo['createdTime'];
            $jobInfo['cashFee'] = 0;
            $jobInfo['buyCashFee'] = 0;
            $jobInfo['price'] = 0;
            $jobInfo['count'] = floatval($jobInfo['amount']);
            $jobInfo['scale'] = floatval($jobInfo['coinScale']);
            $jobInfo['cash'] = 0;
        }
        //获取代金券信息
        $jobInfo['val2'] = 0;
        if ($type == self::SUBSCRIPTION_TYPE || $type == self::BUY_TYPE) {
            $userOrderData = new OrderData();
            $userOrderInfo = $userOrderData->getUserOrder($jobNo, 'UORDER01');
            if (!empty($userOrderInfo)) {
                $voucherNo = $userOrderInfo->userorder_discountno;
                if ($voucherNo != '未使用') {
                    $voucherData = new VoucherInfoData();
                    $voucherInfo = $voucherData->getByNo($voucherNo);
                    if (!empty($voucherInfo)) {
                        $jobInfo['val2'] = $voucherInfo->voucher_val2;
                    }
                }
                $sellNo = array_get($jobInfo, 'sellNo');
                $jobInfo = array_add($jobInfo, 'productName', '');
            } else {
                $jobInfo['val2'] = 0;
            }
            
        }

        //获取分红信息
        if ($type == CashOrderData::BONUS_TYPE) {
            $bonusItemData = new ProjBonusItemData;
            $bonusItem = $bonusItemData->getBonusItem($jobInfo['no']);
            if (!empty($bonusItem)) {
                $jobInfo['bonusCount'] = $bonusItem->bonus_count;
                $jobInfo['bonusCash'] = $bonusItem->bonus_cash;
                $jobInfo['unitBonusCash'] = bcdiv($jobInfo['bonusCash'], $jobInfo['bonusCount'], 2);
                $coinType = $bonusItem->bonus_proj;
                if (!empty($coinType)) {
                    $projectInfo = $projectInfoData->getByNo($coinType);
                    $jobInfo['itemName'] = empty($projectInfo) ? '' : $projectInfo->project_name;
                }
            }

        }

        return $jobInfo;
    }

    /**
     * 查询现金账单的关联表信息
     *
     * @param  $no 现金账单编号
     * @author zhoutao
     */
    public function getCashOrderJob($type, $jobNo)
    {
        $jobData = new $this->_typeToData[$type];
        // switch ($type) {
        //     case CashOrderData::BUY_TYPE:
        //         $jobData = new TranactionOrderData();
        //         break;
        //     case CashOrderData::SELL_TYPE:
        //         $jobData = new TranactionOrderData();
        //         break;
        //     case CashOrderData::WITHDRAWAL_TYPE:
        //         $jobData = new WithdrawalData();
        //         break;
        //     case CashOrderData::RECHARGE_TYPE:
        //         $jobData = new RechargeData();
        //         break;
        //     case CashOrderData::SUBSCRIPTION_TYPE:
        //         $jobData = new TranactionOrderData();
        //         break;
        //     case CashOrderData::VOUCHER_TYPE:
        //         $jobData = new CashJournalData();
        //         break;
        //     case CashOrderData::BONUS_TYPE:
        //         $jobData = new ProjBonusData;
        //         break;
        //     case CashOrderData::BORROW_TYPE
        // }

        $jobInfo = $jobData->getByNo($jobNo);
        return $jobInfo;
    }
}
