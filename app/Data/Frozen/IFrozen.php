<?php
namespace App\Data\Frozen;


/**
 * 冻结接口
 *
 * @author  zhoutao
 * @version 1.0
 * @date    2017.11.10
 * 冻结接口定义
 **/
interface IFrozen
{



    /**
     * 加载数据
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.8
     * @return 
     **/
    public function load_data($frozenType);

    /**
     * 对某笔交易冻结
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.8
     * @return 
     * true 成功
     * false 失败
     */
    public function orderFrozen($orderNo, $date, $freezetime);


}