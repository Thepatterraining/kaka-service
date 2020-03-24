<?php
namespace App\Data\API\LomoCoin;

use App\Data\API\LomoCoin\IVerify;

/**
 * 生产环境的实名验证类
 *
 * @author  geyunfei@kakamf.com
 * @date    Aug 25th,2017
 * @version 1.0
 **/

class ProductVerify implements IVerify
{
    private $_path = '/lianzhuo/idcard';
    private $_host = 'http://idcard.market.alicloudapi.com';
    private $_appCode = '9049be46241e4ca3b049e6c4ab563c81';

    public function VerifyId($name, $id)
    {
        $array = [
            'name' => $name,
            'cardno' => $id,
        ];

        $data = $this->curlGet($this->_host, $array);

        // dump(json_encode($data));
        if ($data->code == 0) {
            return true;
        } else {
            info('ali_idcard_check' . json_encode($data));
            return false;
        }
    }

    private function curlGet($host, $_aryData)
    {
        $url = $host . $this->_path . "?" . http_build_query($_aryData);
        $response = \Httpful\Request::get($url)
            ->addHeader("Authorization", "APPCODE {$this->_appCode}")
            ->send();
        $data = $response->body;
        // dump($data);
        return $data->resp;
    }

    private function sign($_aryData, $_strSignKey = "")
    {
        // 将KEY添加到合并数据
        $_aryData[] = $_strSignKey;
        sort($_aryData, SORT_STRING);
        // 合并数据
        $sign = implode("_", $_aryData);
        // 将字符串签名，获得签名结果
        $sign = md5($sign);
        return $sign;
    }

}
