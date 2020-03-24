<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

/**
 * 代币转账记录表
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.13
 */
class CoinTransferLogData extends IDatafactory
{
    protected $modelclass = 'App\Model\Coin\CoinTransferLog';

    protected $no = 'to';

    const TRANS_TYPE_KYC = 'TLT01';


    const TRANS_STATUS_APPLY = 'TLS01';
    const TRANS_STATUS_SUCCESS = 'TLS02';
    const TRANS_STATUS_FAIL = 'TLS03';

    /**
     * 添加转账记录
     * 
     * @param string $amount    转账数量
     * @param string $from      发起地址
     * @param string $to        用户地址
     * @param string $coinType  代币类型
     * @param string $transType 转账类型
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.13
     */
    public function add($amount, $from, $to, $coinType, $transType)
    {
        $model = $this->newitem();
        $model->trans_type = $transType;
        $model->coin_type = $coinType;
        $model->from = $from;
        $model->to = $to;
        $model->amount = $amount;
        $model->status = self::TRANS_STATUS_APPLY;
        $this->create($model);
    }

    /**
     * 验证转账数量是否正确
     * 
     * @param string $address 用户地址
     * @param int    $count   数量
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.15
     */
    public function check($address, $count)
    {
        $transferLog = $this->getByNo($address);
        if (!empty($transferLog) && $transferLog->amount = $count && $transferLog->status == CoinTransferLogData::TRANS_STATUS_SUCCESS) {
            $status = CoinAddressInfoData::ADDR_TRUE_STATUS;
        } else {
            $status = CoinAddressInfoData::ADDR_FALSE_STATUS;
        }
        $coinAddrData = new CoinAddressInfoData;
        $coinAddrData->saveStatus($address, $status);
    }
}
