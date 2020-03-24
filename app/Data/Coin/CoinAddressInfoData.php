<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;

/**
 * 地址认证信息表
 * 
 * @author zhoutao <zhoutao@kakamf.com>
 * @date   2017.12.7
 */
class CoinAddressInfoData extends IDatafactory
{
    protected $modelclass = 'App\Model\Coin\CoinAddressInfo';
    protected $no = 'coin_address';

    const APPLY_STATUS = 'CAS00';
    const AUTH_TRUE_STATUS = 'CAS01';
    const AUTH_FALSE_STATUS = 'CAS02';
    const ADDR_TRUE_STATUS = 'CAS03';
    const ADDR_FALSE_STATUS = 'CAS04';

    const COL_ADDR = 'coin_address';
    const COL_NAME = 'coin_user_name';
    const COL_IDNO = 'coin_user_idno';
    const COL_MOBILE = 'coin_user_mobile';
    
    /**
     * 用地址和姓名查询信息
     * 
     * @param string $addr 地址
     * @param string $name 身份证姓名
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.8
     * @return $res
     */
    public function getAddr($addr, $name)
    {
        $model = $this->modelclass;
        $where['coin_address'] = $addr;
        $where['coin_user_name'] = $name;
        return $model::where($where)->first();
    }

    /**
     * 查询信息
     * 
     * @param string $key   字段值
     * @param string $value 条件
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.8
     * @return $res
     */
    public function getByKey($key, $value)
    {
        $this->no = $key;
        return $this->getByNo($value);
    }

    /**
     * 修改状态
     * 
     * @param string $addr   地址
     * @param string $status 状态
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.12
     * @return null
     */
    public function saveStatus($addr, $status)
    {
        $coinAddr = $this->getByNo($addr);
        $coinAddr->coin_status = $status;
        $this->save($coinAddr);
    }

    /**
     * 审核成功
     * 
     * @param string $address 地址
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.13
     */
    public function confirmTrue($address)
    {
        //发币
        $coinType = 'KYC';
        $from = '';
        $amount = rand(1000,9999);
        $coinTransferLogData = new CoinTransferLogData;
        $coinTransferLogData->add($amount, $from, $address, $coinType, CoinTransferLogData::TRANS_TYPE_KYC);

        //修改地址状态
        $this->saveStatus($address, self::AUTH_TRUE_STATUS);
    }

    /**
     * 审核失败
     * 
     * @param string $address 地址
     * 
     * @author zhoutao <zhoutao@kakamf.com>
     * @date   2017.12.13
     */
    public function confirmFalse($address)
    {
        //修改地址状态
        $this->saveStatus($address, self::AUTH_FALSE_STATUS);
    }
}
