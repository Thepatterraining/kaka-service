<?php
namespace App\Data\API\Payment;

interface IPayment
{
    /**
     * 发起支付
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.9
     */
    function reqJsPay($appid, $openid, $amount, $jobno, $successUrl, $timeout);
    /**
     * 查询支付状态
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.0
     */
    function queryStatus($jobno);

    /**
     * 检查签名是否正确
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @version 1.0
     */
    function checkSign($data);

    /**
     * 得到数据
     *
     * @author geyunfei (geyunfei@kakamf.com)
     */
    function getData($raw);

    /**
     * 得到通知结果
     *
     * @author  geyunfei (geyunfei@kakamf.com)
     * @date    2017.5.18
     * @version 1.0
     **/
    function getPostResult($raw);
}
