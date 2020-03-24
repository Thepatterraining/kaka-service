<?php
namespace App\Data\Voucher;


/**
 * 代金券接口
 *
 * @author  geyunfei@kakamf.com
 * @version 1.0
 * @date    Sep,6th,2017
 * 现金券接口定义
 **/
interface IVoucher
{



    /**
     * 加载数据
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @param   voucherinfo -- voucher的model 
     * @param   storageinf -- storage的model
     **/
    public function load_data($voucherInfo,$storageInfo);

    /**
     * 检查某个代币是否可以使用
     *
     * @author  geyunfie@kakamf.com
     * @version 1.0
     * @date    Sep,6th,2017;
     * @return 
     * true 可用
     * false 不可用
     **/
    public function CheckByCoinType($price,$coinType);

    /**
     * 检查某个产品是否可以使用 
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0 
     * @date    Sep 6th,2017
     * @return 
     * true 可用
     * false 不可用
     */
    public function CheckByProduct($price,$productNo);


    /**
     * 返回券的使用说明
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @return  String 
     * ex. 满 100减 50；
     **/
    public function GetNotes();

    /**
     * 对某笔交易用券
     *
     * @author  geyunfei@kakamf.com
     * @version 1.0
     * @date    Sep 6th,2017
     * @return 
     * true 成功
     * false 失败
     */
    public function ApplyVoucheToOrder($orderNo, $date, $freezetime);


}