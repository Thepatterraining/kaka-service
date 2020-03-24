<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;

class AddressData extends IDatafactory
{
    /**
     * 创建钱包地址
     *
     * @param  $coinType
     * @param  $userid
     * @return null
     */
    public function createAddress($coinType, $userid, $name, $idno)
    {
        return md5($coinType);
    }

    /**
     * 创建系统钱包地址
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.11.9
     */
    public function createSysAddress($coinType)
    {
        return md5($coinType . 'sys');
    }
}
